<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class AccountantController extends Controller
{
    /**
     * Show the accountant approval view.
     */
    public function approval()
    {
        // Show only transactions forwarded to accountant or previously rejected by accountant
        $payments = Payment::whereIn('status', ['forwarded', 'accountant_rejected'])
            ->orderBy('created_at', 'desc')
            ->paginate(25);
        return view('accountant.accountant', compact('payments'));
    }

    /**
     * Approve a payment.
     */
    public function approve($id)
    {
        $p = Payment::findOrFail($id);
        $p->status = 'approved';
        $p->save();

        return redirect()->route('accountant.approval')->with('success', 'Payment approved.');
    }

    /**
     * Reject a payment.
     */
    public function reject($id)
    {
        $p = Payment::findOrFail($id);
        // Mark as accountant_rejected and allow reviewer to edit/resend
        $p->status = 'accountant_rejected';
        // capture optional remarks
        $remarks = request()->input('remarks');
        $meta = $p->meta ?? [];
        if ($remarks) $meta['accountant_remarks'] = $remarks;
        $p->meta = $meta;
        $p->save();

        return redirect()->route('accountant.approval')->with('success', 'Payment rejected and returned to Reviewer.');
    }
}
