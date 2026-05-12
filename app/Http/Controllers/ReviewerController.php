<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class ReviewerController extends Controller
{
	/**
	 * Show the reviewer view.
	 */
	public function index()
	{
		$payments = Payment::orderBy('created_at', 'desc')->paginate(25);
		return view('reviewer.reviewer', compact('payments'));
	}

	/**
	 * Approve a payment.
	 */
    // Reviewer no longer performs final approve/reject.
    // Reviewer forwards to accountant for final decision.
    public function forward(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = 'forwarded';
        // clear any previous accountant remarks when forwarding again
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
        return redirect()->route('reviewer')->with('success', 'Payment forwarded.');
    }
	/**
 * Update a payment record (Reviewer modify).
 */
public function update(Request $request, $id)
{
    $payment = Payment::findOrFail($id);

    // Prevent modifying payments that have been approved by Accountant
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
    // When reviewer updates a record, mark it as under review
    $payment->status           = 'under_review';

    // Regenerate OP number if fund type changed or OP number was manually cleared
    if ($oldFund !== $newFund || empty($request->input('op_number'))) {
        $prefix = Payment::mapPrefix($newFund);
        $now    = now();
        $year   = $now->format('Y');
        $month  = $now->format('m');
        $like   = $prefix . '-' . $year . '-' . $month . '-%';

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
    $like   = $prefix . '-' . $year . '-' . $month . '-%';

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

