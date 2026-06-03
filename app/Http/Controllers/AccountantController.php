<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Notifications\NewMessageNotification;

class AccountantController extends Controller
{
    /**
     * Show the accountant approval view.
     */
    public function approval()
    {
        // Base filter: forwarded to approver or previously rejected by approver
        $statusParam = request()->query('status', '');
        $fundParam   = request()->query('fund', '');
        $q           = request()->query('search', '');

        $query = Payment::whereIn('status', ['forwarded', 'accountant_rejected'])->orderBy('created_at', 'desc');

        if ($statusParam) {
            $s = strtolower($statusParam);
            if ($s === 'approved') {
                $query->where('status', 'approved');
            } elseif ($s === 'waiting' || $s === 'forwarded') {
                $query->whereIn('status', ['forwarded','submitted','under_review','waiting']);
            } elseif ($s === 'rejected') {
                $query->whereIn('status', ['accountant_rejected','rejected']);
            } else {
                $query->where('status', $s);
            }
        }

        if ($fundParam) {
            $query->where('fund_type', $fundParam);
        }

        if ($q) {
            $query->where(function($qr) use ($q) {
                $qr->where('name', 'like', '%' . $q . '%')
                   ->orWhere('op_number', 'like', '%' . $q . '%')
                   ->orWhere('transaction_type', 'like', '%' . $q . '%');
            });
        }

        $total = (clone $query)->count();
        $waiting = (clone $query)->whereIn('status', ['forwarded', 'accountant_rejected'])->count();
        $approved = (clone $query)->where('status', 'approved')->count();
        $rejected = (clone $query)->where('status', 'accountant_rejected')->count();
        $payments = (clone $query)->paginate(10)->withQueryString();
        $funds = Payment::whereNotNull('fund_type')->select('fund_type')->distinct()->orderBy('fund_type')->pluck('fund_type');
        // Load recent notifications for the authenticated accountant to render in the header
        $notifications = Auth::user()->notifications()->latest()->take(20)->get();
        $notif_data = $notifications->map(function($n) {
            $d = $n->data ?? [];
            return [
                'id' => $n->id,
                'icon' => $d['icon'] ?? 'bi-bell',
                'cls' => $d['cls'] ?? 'ni-gold',
                'text' => $d['message'] ?? ($d['text'] ?? ''),
                'time' => $d['time'] ?? ($n->created_at ? $n->created_at->diffForHumans() : ''),
                'ts' => $n->created_at ? $n->created_at->toIso8601String() : null,
                'unread' => $n->read_at ? false : true,
                'data' => $d,
            ];
        });

        return view('accountant.approval', compact('payments', 'notif_data', 'total', 'waiting', 'approved', 'rejected', 'funds'));
    }

    /**
     * Show approved payments list.
     */
    public function approved()
    {
        $fundParam = request()->query('fund', '');
        $q         = request()->query('search', '');

        $query = Payment::where('status', 'approved')->orderBy('created_at', 'desc');
        if ($fundParam) $query->where('fund_type', $fundParam);
        if ($q) {
            $query->where(function($qr) use ($q) {
                $qr->where('name', 'like', '%' . $q . '%')
                   ->orWhere('op_number', 'like', '%' . $q . '%')
                   ->orWhere('transaction_type', 'like', '%' . $q . '%');
            });
        }

        $total = (clone $query)->count();
        $totalSum = (clone $query)->sum('amount');
        $approvedPayments = (clone $query)->paginate(10)->withQueryString();
        $funds = Payment::whereNotNull('fund_type')->select('fund_type')->distinct()->orderBy('fund_type')->pluck('fund_type');

        // Load recent notifications for the authenticated accountant to render in the header
        $notifications = Auth::user() ? Auth::user()->notifications()->latest()->take(20)->get() : collect([]);
        $notif_data = $notifications->map(function($n) {
            $d = $n->data ?? [];
            return [
                'id' => $n->id,
                'icon' => $d['icon'] ?? 'bi-bell',
                'cls' => $d['cls'] ?? 'ni-gold',
                'text' => $d['message'] ?? ($d['text'] ?? ''),
                'time' => $d['time'] ?? ($n->created_at ? $n->created_at->diffForHumans() : ''),
                'ts' => $n->created_at ? $n->created_at->toIso8601String() : null,
                'unread' => $n->read_at ? false : true,
                'data' => $d,
            ];
        });

        return view('accountant.approvedlist', compact('approvedPayments', 'notif_data', 'total', 'totalSum', 'funds'));
    }

    /**
     * Show accountant profile page.
     */
    public function profile()
    {
        // Load recent notifications for the authenticated accountant to render in the header
        $notifications = Auth::user() ? Auth::user()->notifications()->latest()->take(20)->get() : collect([]);
        $notif_data = $notifications->map(function($n) {
            $d = $n->data ?? [];
            return [
                'id' => $n->id,
                'icon' => $d['icon'] ?? 'bi-bell',
                'cls' => $d['cls'] ?? 'ni-gold',
                'text' => $d['message'] ?? ($d['text'] ?? ''),
                'time' => $d['time'] ?? ($n->created_at ? $n->created_at->diffForHumans() : ''),
                'ts' => $n->created_at ? $n->created_at->toIso8601String() : null,
                'unread' => $n->read_at ? false : true,
                'data' => $d,
            ];
        });

        return view('accountant.profile', compact('notif_data'));
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
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        // Handle uploaded profile picture separately
        $oldPicture = $user->profile_picture;
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        // Remove file from fillable data
        if (array_key_exists('profile_picture', $data)) {
            unset($data['profile_picture']);
        }

        $user->fill($data);
        $user->save();

        // Delete old picture if replaced
        if (!empty($path) && $oldPicture && $oldPicture !== $path) {
            try { Storage::disk('public')->delete($oldPicture); } catch (\Throwable $e) { /* ignore */ }
        }

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
        try {
            $reviewerRoleId = DB::table('roles')->where('name', 'reviewer')->value('id');
            if ($reviewerRoleId) {
                $reviewers = User::where('role_id', $reviewerRoleId)->get();
                foreach ($reviewers as $r) {
                    $r->notify(new NewMessageNotification($p));
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to notify reviewers on approve: ' . $e->getMessage());
        }
        // Notify makers about approval
        try {
            $makerRoleId = DB::table('roles')->where('name', 'maker')->value('id');
            if ($makerRoleId) {
                $makers = User::where('role_id', $makerRoleId)->get();
                foreach ($makers as $m) {
                    $m->notify(new NewMessageNotification($p));
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to notify makers on approve: ' . $e->getMessage());
        }

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
        try {
            $reviewerRoleId = DB::table('roles')->where('name', 'reviewer')->value('id');
            if ($reviewerRoleId) {
                $reviewers = User::where('role_id', $reviewerRoleId)->get();
                foreach ($reviewers as $r) {
                    $r->notify(new NewMessageNotification($p));
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to notify reviewers on reject: ' . $e->getMessage());
        }

        // Notify makers about rejection
        try {
            $makerRoleId = DB::table('roles')->where('name', 'maker')->value('id');
            if ($makerRoleId) {
                $makers = User::where('role_id', $makerRoleId)->get();
                foreach ($makers as $m) {
                    $m->notify(new NewMessageNotification($p));
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to notify makers on reject: ' . $e->getMessage());
        }

        return redirect()->route('accountant.approval')->with('success', 'Payment rejected and returned to Reviewer.');
    }

    /**
     * Remove the authenticated user's profile picture.
     */
    public function removeProfilePicture(Request $request)
    {
        $user = Auth::user();
        if (! $user) return redirect()->route('accountant.profile')->with('error', 'Unauthorized.');

        $old = $user->profile_picture;
        if ($old && Storage::disk('public')->exists($old)) {
            try { Storage::disk('public')->delete($old); } catch (\Throwable $e) { /* ignore */ }
        }
        $user->profile_picture = null;
        $user->save();

        return redirect()->route('accountant.profile')->with('success', 'Profile picture removed.');
    }
}
