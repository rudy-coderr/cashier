<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class DashboardController extends Controller
{
    /**
     * Show the dashboard view.
     */
    public function index()
    {
        return view('dashboard.dashboard');
    }

    // Show payment creation form (reuses payments.create view)
    public function createPayment()
    {
        return view('payments.create');
    }

    // List saved payments
    public function listPayments()
    {
        $payments = Payment::orderBy('created_at', 'desc')->paginate(25);
        return view('payments.index', compact('payments'));
    }

    /**
     * Handle dashboard form submissions (payment processing stub).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'transaction_type' => 'sometimes|string|nullable',
            'amount' => 'required|numeric|min:0',
            'name' => 'required|string|max:191',
            'contact' => 'required|string|max:50',
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:191',
            'agree_terms' => 'accepted',
        ]);

        // persist to payments table
        $meta = $request->except(['_token', 'transaction_type', 'fund_type', 'amount', 'name', 'contact', 'address', 'email', 'payment_mode', 'agree_terms']);

        Payment::create([
            'transaction_type' => $data['transaction_type'] ?? null,
            'fund_type' => $request->input('fund_type'),
            'amount' => $data['amount'],
            'name' => $data['name'],
            'contact' => $data['contact'],
            'address' => $data['address'],
            'email' => $data['email'],
            'payment_mode' => $request->input('payment_mode'),
            'meta' => $meta,
            'status' => 'waiting',
        ]);

        return redirect()->route('payments.index')->with('success', 'Payment saved.');
    }
}
