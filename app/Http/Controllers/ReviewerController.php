<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\AuditLog;
use App\Models\OpNumberHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Notifications\NewMessageNotification;

class ReviewerController extends Controller
{
    /**
     * Show the reviewer view.
     */
    public function index()
    {
        $openFunds = request()->query('open_funds') ? true : false;

        $status = request()->query('status', '');
        $fund   = request()->query('fund', '');
        $q      = request()->query('search', '');
        $notifId = request()->query('notif_id', '');

        $query = Payment::orderBy('created_at', 'desc');

        // Apply status filter (map friendly keys to actual status values)
        if ($status) {
            $s = strtolower($status);
            if ($s === 'approved') {
                $query->where('status', 'approved');
            } elseif ($s === 'waiting') {
                $query->whereIn('status', ['submitted','under_review','waiting']);
            } elseif ($s === 'rejected') {
                $query->whereIn('status', ['rejected','accountant_rejected']);
            } else {
                // direct match for any other status string
                $query->where('status', $s);
            }
        }

        // Apply fund filter
        if ($fund) {
            $query->where('fund_type', $fund);
        }

        // If notif_id is provided, try to find the notification and narrow to that payment
        if ($notifId) {
            try {
                $user = auth()->user();
                if ($user) {
                    $note = $user->notifications()->where('id', $notifId)->first();
                    if ($note) {
                        $ndata = $note->data ?? [];
                        if (!empty($ndata['payment_id'])) {
                            $query->where('id', $ndata['payment_id']);
                        } elseif (!empty($ndata['op_number']) || !empty($ndata['op'])) {
                            $q = $ndata['op_number'] ?? $ndata['op'];
                        }
                    }
                }
            } catch (\Throwable $e) {
                // ignore and fall back to normal search
            }
        }

        // Apply search across name, op_number and transaction_type
        if ($q) {
            $query->where(function($qr) use ($q) {
                $qr->where('name', 'like', '%' . $q . '%')
                   ->orWhere('op_number', 'like', '%' . $q . '%')
                   ->orWhere('transaction_type', 'like', '%' . $q . '%');
            });
        }

        // Compute aggregates for the filtered dataset before pagination
        $totalCount    = (clone $query)->count();
        $totalSum      = (clone $query)->sum('amount');
        $awaitingCount = (clone $query)->whereIn('status', ['submitted','under_review','waiting'])->count();
        $approvedCount = (clone $query)->where('status', 'approved')->count();

        // Paginate the filtered query; keep query string for links
        $payments = (clone $query)->paginate(10)->withQueryString();

        return view('reviewer.reviewer', compact('payments', 'openFunds', 'totalCount', 'totalSum', 'awaitingCount', 'approvedCount'));
    }

    /**
     * Forward a payment to accountant.
     */
    public function forward(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = 'forwarded';
        $meta = $payment->meta ?? [];
        unset($meta['accountant_remarks']);
        $payment->meta = $meta;
        $payment->save();

        // Log the forward action with a clear description
        try {
            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => 'forward',
                'description' => 'Forwarded payment #' . $payment->id . ' to Accountant',
                'ip_address' => $request->ip(),
            ]);
        } catch (\Throwable $e) {
            // ignore logging errors
        }
        // Notify accountants that a payment has been forwarded
        try {
            $accountantRoleId = DB::table('roles')->where('name', 'accountant')->value('id');
            if ($accountantRoleId) {
                $accountants = User::where('role_id', $accountantRoleId)->get();
                foreach ($accountants as $a) {
                    $a->notify(new NewMessageNotification($payment));
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to notify accountants on forward: ' . $e->getMessage());
        }
        // Also notify makers about the forward action
        try {
            $makerRoleId = DB::table('roles')->where('name', 'maker')->value('id');
            if ($makerRoleId) {
                $makers = User::where('role_id', $makerRoleId)->get();
                foreach ($makers as $m) {
                    $m->notify(new NewMessageNotification($payment));
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to notify makers on forward: ' . $e->getMessage());
        }
        return redirect()->route('reviewer')->with('success', 'Payment forwarded.');
    }

    /**
     * Update a payment record (Reviewer modify).
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        if (($payment->status ?? '') === 'approved') {
            return redirect()->route('reviewer')->with('error', 'Approved payments cannot be modified.');
        }

        $oldFund = $payment->fund_type;
        $newFund = $request->input('fund_type');

        $payment->name             = $request->input('name');
        $payment->email            = $request->input('email');
        $payment->contact          = $request->input('contact');
        $payment->address          = $request->input('address');
        $payment->amount           = $request->input('amount');
        $payment->transaction_type = $request->input('transaction_type');
        $payment->fund_type        = $newFund;
        $payment->payment_mode     = $request->input('payment_mode');
        $payment->status           = 'under_review';

        // When fund changes, try to reuse a previously assigned OP number for this payment+fund.
        if ($oldFund !== $newFund || empty($request->input('op_number'))) {
            $history = OpNumberHistory::where('payment_id', $payment->id)
                ->where('fund_type', $newFund)
                ->first();

            if ($history && !empty($history->op_number)) {
                $payment->op_number = $history->op_number;
            } else {
                $prefix = Payment::mapPrefix($newFund);
                $now    = now();
                $year   = $now->format('Y');
                $month  = $now->format('m');

                // Use year-only pattern when searching so the sequence is annual.
                $like   = $prefix . '-' . $year . '-%';

                $last = Payment::where('op_number', 'like', $like)
                    ->where('id', '!=', $id)
                    ->orderBy('op_number', 'desc')
                    ->first();

                if ($last && preg_match('/-(\d{4})$/', $last->op_number, $m)) {
                    $seq = intval($m[1]) + 1;
                } else {
                    $seq = 1;
                }

                $payment->op_number = sprintf('%s-%s-%s-%04d', $prefix, $year, $month, $seq);

                OpNumberHistory::updateOrCreate(
                    ['payment_id' => $payment->id, 'fund_type' => $newFund],
                    ['op_number' => $payment->op_number]
                );
            }
        } else {
            $payment->op_number = $request->input('op_number');
        }

        // Meta fields
        $txn  = $request->input('transaction_type');
        $meta = $payment->meta ?? [];

        $meta['reviewer_remarks'] = $request->input('reviewer_remarks');

        switch ($txn) {
            case 'appeal_fee':
                $meta['appeal_remarks'] = $request->input('appeal_remarks');
                break;
            case 'bidding_documents':
                $meta['bid_details'] = $request->input('bid_details');
                $meta['bid_remarks'] = $request->input('bid_remarks');
                break;
            case 'cash_bond':
                $meta['area_hectares']     = $request->input('area_hectares');
                $meta['zonal_value']       = $request->input('zonal_value');
                $meta['property_location'] = $request->input('property_location');
                $meta['assessment_form']   = $request->input('assessment_form');
                $meta['cash_bond_remarks'] = $request->input('cash_bond_remarks');
                break;
            case 'certification_copy_fee':
                $meta['letter_request'] = $request->input('letter_request');
                $meta['cert_type']      = $request->input('cert_type', []);
                $meta['cert_remarks']   = $request->input('cert_remarks');
                break;
            case 'consignment':
                $meta['consignment_assessment_form'] = $request->input('consignment_assessment_form');
                $meta['consignment_case_no']         = $request->input('consignment_case_no');
                $meta['consignment_remarks']         = $request->input('consignment_remarks');
                break;
            case 'execution_judgment':
                $meta['exec_assessment_form'] = $request->input('exec_assessment_form');
                $meta['exec_txn_type_paid']   = $request->input('exec_txn_type_paid');
                $meta['exec_remarks']         = $request->input('exec_remarks');
                break;
            case 'filing_fee':
                $meta['filing_assessment_form'] = $request->input('filing_assessment_form');
                $meta['filing_remarks']         = $request->input('filing_remarks');
                break;
            case 'income_unserviceable':
                $meta['rdc_resolution_no']     = $request->input('rdc_resolution_no');
                $meta['unserviceable_remarks'] = $request->input('unserviceable_remarks');
                break;
            case 'legal_research':
                $meta['legal_research_remarks'] = $request->input('legal_research_remarks');
                break;
            case 'performance_bond':
                $meta['pb_area_hectares']     = $request->input('pb_area_hectares');
                $meta['pb_zonal_value']       = $request->input('pb_zonal_value');
                $meta['pb_property_location'] = $request->input('pb_property_location');
                $meta['pb_assessment_form']   = $request->input('pb_assessment_form');
                $meta['pb_remarks']           = $request->input('pb_remarks');
                break;
            case 'refund_cash_advances':
                $meta['check_lddap_ada']      = $request->input('check_lddap_ada');
                $meta['cash_advance_date']    = $request->input('cash_advance_date');
                $meta['division_section']     = $request->input('division_section');
                $meta['cash_advance_remarks'] = $request->input('cash_advance_remarks');
                break;
            case 'refund_overpayment':
                $meta['refund_division_section'] = $request->input('refund_division_section');
                $meta['refund_op_remarks']       = $request->input('refund_op_remarks');
                break;
            case 'settlement_disallowances':
                $meta['disallowance_no']      = $request->input('disallowance_no');
                $meta['disallowance_remarks'] = $request->input('disallowance_remarks');
                break;
            case 'unwithheld_remittances':
                $meta['remit_type']          = $request->input('remit_type', []);
                $meta['remit_other_specify'] = $request->input('remit_other_specify');
                $meta['remit_remarks']       = $request->input('remit_remarks');
                break;
        }

        $payment->meta = $meta;
        $payment->save();

        // Notify makers that the payment was modified
        try {
            $makerRoleId = DB::table('roles')->where('name', 'maker')->value('id');
            if ($makerRoleId) {
                $makers = User::where('role_id', $makerRoleId)->get();
                foreach ($makers as $m) {
                    $m->notify(new NewMessageNotification($payment));
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to notify makers on modify: ' . $e->getMessage());
        }

        return redirect()->route('reviewer')->with('success', 'Payment record updated successfully.');
    }

    public function nextOpNumber(Request $request)
    {
        $fundCode = $request->query('fund');
        $excludeId = $request->query('exclude');

        $prefix = Payment::mapPrefix($fundCode);
        $now    = now();
        $year   = $now->format('Y');
        $month  = $now->format('m');

        // Next OP number should consider the whole year so sequence increments across months.
        $like   = $prefix . '-' . $year . '-%';

        $query = Payment::where('op_number', 'like', $like);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $last = $query->orderBy('op_number', 'desc')->first();

        if ($last && preg_match('/-(\d{4})$/', $last->op_number, $m)) {
            $seq = intval($m[1]) + 1;
        } else {
            $seq = 1;
        }

        return response()->json([
            'op_number' => sprintf('%s-%s-%s-%04d', $prefix, $year, $month, $seq)
        ]);
    }
}
