<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
            ->paginate(10);
        return view('accountant.approval', compact('payments'));
    }

    /**
     * Show approved payments list.
     */
    public function approved()
    {
        $approvedPayments = Payment::where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('accountant.approvedlist', compact('approvedPayments'));
    }

    /**
     * Show accountant profile page.
     */
    public function profile()
    {
        return view('accountant.profile');
    }

    /**
     * Update accountant profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => ['nullable','string','max:255', Rule::unique('users')->ignore($user->id)],
            'phone_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:1000',
        ]);

        $user->fill($data);
        $user->save();

        return redirect()->route('accountant.profile')->with('success', 'Profile updated.');
    }

    /**
     * Update accountant password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($data['current_password'], $user->password)) {
            return redirect()->route('accountant.profile')->with('error', 'Current password is incorrect.');
        }

        $user->password = Hash::make($data['password']);
        $user->save();

        return redirect()->route('accountant.profile')->with('success', 'Password updated.');
    }

    /**
     * Approve a payment.
     */
    public function approve($id)
    {
        $p = Payment::findOrFail($id);
        $p->status = 'approved';
        $p->save();

        // Log approval with clear description
        try {
            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => 'approve',
                'description' => 'Approved payment #' . $p->id,
                'ip_address' => request()->ip(),
            ]);
        } catch (\Throwable $e) { /* ignore */ }

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

        try {
            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => 'reject',
                'description' => 'Rejected payment #' . $p->id . (isset($remarks) ? (': ' . substr($remarks,0,200)) : ''),
                'ip_address' => request()->ip(),
            ]);
        } catch (\Throwable $e) { /* ignore */ }

        return redirect()->route('accountant.approval')->with('success', 'Payment rejected and returned to Reviewer.');
    }
}
