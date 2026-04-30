<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the dashboard view.
     */
    public function index()
    {
        return view('dashboard.dashboard');
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
            'op_number' => 'required|string|max:100',
            'agree_terms' => 'accepted',
        ]);

        // TODO: implement actual processing / persistence.
        // For now, flash a success message and redirect back to dashboard.
        return redirect()->route('dashboard')->with('success', 'Payment submitted (stub).');
    }
}
