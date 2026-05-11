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
        $payments = Payment::orderBy('created_at', 'desc')->paginate(25);
        return view('accountant.approval', compact('payments'));
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
        $p->status = 'rejected';
        $p->save();

        return redirect()->route('accountant.approval')->with('success', 'Payment rejected.');
    }
}
