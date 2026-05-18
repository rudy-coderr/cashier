<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class MakerController extends Controller
{
    /**
     * Show the dashboard view.
     */
    public function index()
    {
        return view('maker.maker.maker');
    }

    // Show payment creation form (reuses payments.create view)
    public function createPayment()
    {
        // Render the Maker "New Transaction" page for Maker users
        return view('maker.maker.maker');
    }

    // Show payment creation form for Reviewer inside reviewer layout (route guarded by reviewer middleware)
    public function createForReviewer(Request $request)
    {
        return view('maker.maker.maker');
    }

    // List saved payments
    public function listPayments()
    {
        $payments = Payment::orderBy('created_at', 'desc')->paginate(25);
        return view('maker.payments.payments', compact('payments'));
    }

    /**
     * Return recent payments as JSON for AJAX consumption.
     */
    public function paymentsJson()
    {
        $payments = Payment::orderBy('created_at', 'desc')->take(200)->get();

        $data = $payments->map(function ($p) {
            $raw = $p->status ?? 'waiting';
            if (in_array($raw, ['approved'])) {
                $status = 'approved';
            } elseif (in_array($raw, ['rejected', 'accountant_rejected'])) {
                $status = 'rejected';
            } else {
                $status = 'waiting';
            }

            return [
                'id' => $p->id,
                'name' => $p->name,
                'email' => $p->email,
                'contact' => $p->contact,
                'amount' => number_format($p->amount, 2),
                'amountRaw' => (float) $p->amount,
                'transaction_type' => $p->transaction_type,
                'fund_type' => $p->fund_type,
                'op_number' => $p->op_number,
                'status' => $status,
                'created_at' => $p->created_at ? $p->created_at->toDateTimeString() : null,
            ];
        });

        return response()->json($data);
    }

    /**
     * Handle dashboard form submissions (payment processing stub).
     */
    public function store(Request $request)
    {
        // Debug CSRF/session data to diagnose 419 errors
        Log::info('CSRF debug - incoming', [
            'route' => $request->route()?->getName(),
            'session_id' => $request->session()->getId(),
            'session_token' => $request->session()->token(),
            'form__token' => $request->input('_token'),
            'header_x_csrf' => $request->header('X-CSRF-TOKEN'),
            'cookie_header' => $request->headers->get('cookie'),
        ]);

        $data = $request->validate([
            'transaction_type' => 'sometimes|string|nullable',
            'amount' => 'required|numeric|min:0',
            'name' => 'required|string|max:191',
            'contact' => 'required|string|max:50',
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:191',
            'agree_terms' => 'accepted',
        ]);
        $meta = $request->except(['_token', 'transaction_type', 'fund_type', 'amount', 'name', 'contact', 'address', 'email', 'payment_mode', 'agree_terms']);

        // Log incoming submission for debugging
        Log::info('Maker store called', ['route' => $request->route()?->getName(), 'data' => $request->except(['_token'])]);

        try {
            $payment = Payment::create([
                'transaction_type' => $data['transaction_type'] ?? null,
                'fund_type' => $request->input('fund_type'),
                'amount' => $data['amount'],
                'name' => $data['name'],
                'contact' => $data['contact'],
                'address' => $data['address'],
                'email' => $data['email'],
                'payment_mode' => $request->input('payment_mode'),
                'meta' => $meta,
                'status' => 'submitted',
            ]);
            Log::info('Payment created', ['id' => $payment->id]);
        } catch (\Exception $e) {
            Log::error('Payment create failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withInput()->with('error', 'Failed to save payment: ' . $e->getMessage());
        }

        $routeName = $request->route() ? $request->route()->getName() : null;

        // If submitted from the Maker dashboard, return there.
        if ($routeName === 'dashboard.store') {
            return redirect()->route('dashboard')->with('success', 'Payment saved.');
        }

        // If submitted from a reviewer-scoped route, redirect back to reviewer area.
        if ($routeName && str_starts_with($routeName, 'reviewer.')) {
            return redirect()->route('reviewer')->with('success', 'Payment saved.');
        }

        // Default: go to payments listing (Maker view).
        return redirect()->route('payments.index')->with('success', 'Payment saved.');
    }
}
