<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

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
	public function approve($id)
	{
		$payment = Payment::findOrFail($id);
		$payment->status = 'approved';
		$payment->save();
		return redirect()->route('reviewer')->with('success', 'Payment approved.');
	}

	/**
	 * Reject a payment.
	 */
	public function reject($id)
	{
		$payment = Payment::findOrFail($id);
		$payment->status = 'rejected';
		$payment->save();
		return redirect()->route('reviewer')->with('success', 'Payment rejected.');
	}
}

