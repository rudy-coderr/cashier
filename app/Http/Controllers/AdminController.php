<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\AuditLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserCredentials;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
	/**
	 * Show the admin view.
	 */
	public function index()
	{
		// Dashboard metrics
		$totalUsers = User::count();
		$totalTransactions = Payment::count();
		$pendingApprovals = Payment::where('status', 'pending')->count();
		$totalCollected = Payment::where('status', 'approved')->sum('amount');
		// show most-recently updated payments so approvals/rejections surface immediately
		$recentPayments = Payment::orderBy('updated_at', 'desc')->limit(6)->get();
		$recentUsers = User::orderBy('created_at', 'desc')->limit(6)->get();
		// Count approvals/rejections by updated_at so actions performed today are counted
		$approvedCount = Payment::whereDate('updated_at', today())->where('status','approved')->count();
		// consider both standard 'rejected' and 'accountant_rejected' statuses
		$rejectedCount = Payment::whereDate('updated_at', today())
			->whereIn('status', ['rejected', 'accountant_rejected'])
			->count();
		$activeUsers = User::where('status','active')->count();
		// audit_logs table may not exist on all installs — check first
		if (Schema::hasTable('audit_logs')) {
			$logsToday = DB::table('audit_logs')->whereDate('created_at', today())->count();
		} else {
			$logsToday = 0;
		}
		$avgAmount = Payment::whereDate('created_at', today())->avg('amount') ?? 0;

		return view('admin.dashboard', compact('totalUsers','totalTransactions','pendingApprovals','totalCollected','recentPayments','recentUsers','approvedCount','rejectedCount','activeUsers','logsToday','avgAmount'));
	}

	/**
	 * Export users as CSV
	 */
	public function exportUsers()
	{
		$users = User::orderBy('id')->get();

		$filename = 'users-' . now()->format('Ymd-His') . '.csv';
		$headers = [
			'Content-Type' => 'text/csv',
			'Content-Disposition' => "attachment; filename=\"{$filename}\"",
		];

		$callback = function() use ($users) {
			$out = fopen('php://output', 'w');
			fputcsv($out, ['id','first_name','middle_name','last_name','email','username','position','status','created_at']);
			foreach ($users as $u) {
				fputcsv($out, [$u->id,$u->first_name,$u->middle_name,$u->last_name,$u->email,$u->username,$u->position,$u->status,$u->created_at]);
			}
			fclose($out);
		};

		return response()->stream($callback, 200, $headers);
	}

	/**
	 * Show users management page.
	 */
	public function users()
	{
		$users = User::orderBy('id', 'desc')->get();

		// load role names map (if roles table exists)
		$rolesMap = DB::table('roles')->pluck('name', 'id');

		$totalUsers = $users->count();
		$counts = ['maker' => 0, 'reviewer' => 0, 'accountant' => 0];

		// enrich users with `role`, `last_login_at` (from sessions) and `is_active`
		foreach ($users as $u) {
			// derive role: prefer roles table via role_id, fallback to position column
			$u->role = isset($u->role_id) && $u->role_id ? ($rolesMap[$u->role_id] ?? $u->position) : ($u->position ?? null);

			// aggregate counts
			$r = strtolower($u->role ?? '');
			if (isset($counts[$r])) $counts[$r]++;

			// determine last login time from sessions table (last_activity unix timestamp)
			$sess = DB::table('sessions')->where('user_id', $u->id)->orderBy('last_activity', 'desc')->first();
			if ($sess && isset($sess->last_activity)) {
				$u->last_login_at = Carbon::createFromTimestamp($sess->last_activity);
			} else {
				$u->last_login_at = null;
			}

			// boolean is_active based on status column if present
			if (isset($u->status)) {
				$u->is_active = ($u->status === 'active');
			} else {
				$u->is_active = true;
			}
			// computed display name from name parts (for compatibility with views)
			$u->name = trim(($u->first_name ?? '') . ' ' . ($u->middle_name ?? '') . ' ' . ($u->last_name ?? ''));
		}

		$makerCount = $counts['maker'];
		$reviewerCount = $counts['reviewer'];
		$accountantCount = $counts['accountant'];

		return view('admin.users', compact('users', 'totalUsers', 'makerCount', 'reviewerCount', 'accountantCount'));
	}

	/**
	 * Show audit logs.
	 */
	public function auditlogs(Request $request)
	{
		if (Schema::hasTable('audit_logs')) {
			$query = AuditLog::with('user')->orderBy('created_at', 'desc');

			// filter by action (exact match)
			if ($request->filled('action')) {
				$query->where('action', $request->input('action'));
			}

			// fulltext-ish search across description, action and related user fields
			if ($request->filled('search')) {
				$term = $request->input('search');
				$query->where(function($q) use ($term) {
					$q->where('description', 'like', "%{$term}%")
					  ->orWhere('action', 'like', "%{$term}%")
					  ->orWhereHas('user', function($uq) use ($term) {
						$uq->where('email', 'like', "%{$term}%")
						   ->orWhere('username', 'like', "%{$term}%")
						   ->orWhere('first_name', 'like', "%{$term}%")
						   ->orWhere('last_name', 'like', "%{$term}%");
					});
				});
			}

			$logs = $query->paginate(10)->appends($request->query());
		} else {
			$logs = collect([]);
		}

		return view('admin.auditlogs', compact('logs'));
	}

	/**
	 * Show reports page.
	 */
	public function reports()
	{
		$reportTypes = [
			['key' => 'daily', 'label' => 'Daily Transactions'],
			['key' => 'monthly', 'label' => 'Monthly Summary'],
			['key' => 'funds', 'label' => 'Funds Breakdown'],
		];

		// load transactions for history (paginated)
		$transactions = Payment::orderBy('created_at', 'desc')->paginate(10);

		return view('admin.transactionhistory', compact('reportTypes', 'transactions'));
	}

	/**
	 * Store a newly created user from admin dashboard.
	 */
	public function store(Request $request)
	{
		$data = $request->validate([
			'first_name' => 'sometimes|string|max:191',
			'middle_name' => 'sometimes|string|max:191|nullable',
			'last_name' => 'sometimes|string|max:191',
			'username' => 'sometimes|string|max:191|nullable',
			'email' => 'required|email|max:191|unique:users,email',
			'password' => 'sometimes|string|min:6|nullable',
			'phone_number' => 'sometimes|string|nullable',
			'address' => 'sometimes|string|nullable',
			'position' => 'sometimes|string|nullable',
			'status' => 'sometimes|in:active,inactive,banned',
		]);

		$user = new User();
		$user->first_name = $request->input('first_name', $request->input('name', ''));
		$user->middle_name = $request->input('middle_name');
		$user->last_name = $request->input('last_name', '');
		$user->username = $request->input('username');
		$user->email = $request->input('email');
		$plainPassword = $request->filled('password') ? $request->input('password') : $this->generatePassword(8);
		$user->password = Hash::make($plainPassword);
		$user->phone_number = $request->input('phone_number');
		$user->address = $request->input('address');
		$user->position = $request->input('position');

		// Resolve role_id from roles table when a position/role name is selected
		$roleId = null;
		if (!empty($user->position)) {
			$roleId = DB::table('roles')->where('name', $user->position)->value('id');
		}
		$user->role_id = $roleId;
		$user->status = $request->input('status', 'active');
		$user->save();

		// send credentials email (best-effort, don't block user creation on failure)
		try {
			if ($user->email) {
				Log::info('Attempting to send new user credentials email', ['email' => $user->email, 'user_id' => $user->id]);
				Mail::to($user->email)->send(new NewUserCredentials($user, $plainPassword));
				Log::info('Sent new user credentials email', ['email' => $user->email, 'user_id' => $user->id]);
			}
		} catch (\Exception $e) {
			Log::error('Failed to send new user credentials email: ' . $e->getMessage());
		}

		return redirect()->route('admin.users')->with('success', 'User created.');
	}

	/**
	 * Generate a secure password containing at least one uppercase,
	 * one lowercase, one digit and one special character.
	 * Allowed special characters: ! @ # $ % ^ & *
	 */
	private function generatePassword(int $length = 8): string
	{
		$upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$lower = 'abcdefghijklmnopqrstuvwxyz';
		$digits = '0123456789';
		$special = '!@#$%^&*';
		$all = $upper . $lower . $digits . $special;

		$password = [];
		$password[] = $upper[random_int(0, strlen($upper) - 1)];
		$password[] = $lower[random_int(0, strlen($lower) - 1)];
		$password[] = $digits[random_int(0, strlen($digits) - 1)];
		$password[] = $special[random_int(0, strlen($special) - 1)];

		for ($i = 4; $i < $length; $i++) {
			$password[] = $all[random_int(0, strlen($all) - 1)];
		}

		shuffle($password);

		return implode('', $password);
	}

	/**
	 * Toggle user status between active/inactive.
	 */
	public function toggle($id)
	{
		$user = User::findOrFail($id);
		$user->status = $user->status === 'active' ? 'inactive' : 'active';
		$user->save();
		return redirect()->route('admin.dashboard')->with('success', 'User status updated.');
	}

	/**
	 * Remove the specified user.
	 */
	public function destroy($id)
	{
		$user = User::findOrFail($id);
		$user->delete();
		return redirect()->route('admin.users')->with('success', 'User deleted.');
	}

	/**
	 * Display a single user's details.
	 */
	public function show($id)
	{
		$user = User::findOrFail($id);
		// determine last login (same logic as users list)
		$sess = DB::table('sessions')->where('user_id', $user->id)->orderBy('last_activity', 'desc')->first();
		if ($sess && isset($sess->last_activity)) {
			$user->last_login_at = Carbon::createFromTimestamp($sess->last_activity);
		} else {
			$user->last_login_at = null;
		}
		$user->role = isset($user->role_id) && $user->role_id ? DB::table('roles')->where('id', $user->role_id)->value('name') : ($user->position ?? null);
		return view('admin.user_show', compact('user'));
	}

	/**
	 * Show simple profile view.
	 */
	public function profile(Request $request)
	{
		return view('admin.profile');
	}

	/**
	 * Update basic profile fields for the current user.
	 */
	public function updateProfile(Request $request)
	{
		$user = $request->user();
		$data = $request->validate([
			'first_name' => 'sometimes|string|max:191',
			'middle_name' => 'sometimes|string|max:191|nullable',
			'last_name' => 'sometimes|string|max:191',
			'username' => 'sometimes|string|max:191|nullable|unique:users,username,'.$user->id,
			'email' => 'required|email|max:191|unique:users,email,'.$user->id,
			'phone_number' => 'sometimes|string|nullable',
			'address' => 'sometimes|string|nullable',
			'profile_picture' => 'sometimes|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
		]);

		$user->first_name = $request->input('first_name', $user->first_name);
		$user->middle_name = $request->input('middle_name', $user->middle_name);
		$user->last_name = $request->input('last_name', $user->last_name);
		$user->email = $request->input('email', $user->email);
		$user->username = $request->input('username', $user->username);
		$user->phone_number = $request->input('phone_number', $user->phone_number);
		$user->address = $request->input('address', $user->address);

		if ($request->hasFile('profile_picture')) {
			$file = $request->file('profile_picture');
			$path = $file->store('avatars', 'public');
			if (!empty($user->profile_picture) && Storage::disk('public')->exists($user->profile_picture)) {
				Storage::disk('public')->delete($user->profile_picture);
			}
			$user->profile_picture = $path;
		}
 
		$user->save();

		return redirect()->route('profile')->with('success', 'Profile updated.');
	}

	/**
	 * Change current user's password.
	 */
	public function updatePassword(Request $request)
	{
		$user = $request->user();
		$data = $request->validate([
			'current_password' => 'required',
			'password' => 'required|string|min:8|confirmed',
		]);

		if (!Hash::check($request->input('current_password'), $user->password)) {
			return redirect()->route('profile')->with('error', 'Current password is incorrect.');
		}

		$user->password = Hash::make($request->input('password'));
		$user->save();

		return redirect()->route('profile')->with('success', 'Password updated.');
	}

	/**
	 * Generate a report (stub handler).
	 */
	public function generateReport(Request $request)
	{
		$data = $request->validate([
			'report_type' => 'required|string',
			'from' => 'sometimes|date|nullable',
			'to' => 'sometimes|date|nullable',
			'fund_id' => 'sometimes|integer|nullable',
		]);

		// Placeholder: implement actual report generation and response/download.
		return redirect()->route('admin.dashboard')->with('success', 'Report generation requested.');
	}

	/**
	 * Update an existing user from admin dashboard.
	 */
	public function update(Request $request, $id)
	{
		$user = User::findOrFail($id);

		$data = $request->validate([
			'first_name' => 'sometimes|string|max:191',
			'middle_name' => 'sometimes|string|max:191|nullable',
			'last_name' => 'sometimes|string|max:191',
			'username' => 'sometimes|string|max:191|nullable',
			'email' => 'required|email|max:191|unique:users,email,'.$user->id,
			'password' => 'sometimes|string|min:8|nullable',
			'phone_number' => 'sometimes|string|nullable',
			'address' => 'sometimes|string|nullable',
			'position' => 'sometimes|string|nullable',
			'status' => 'sometimes|in:active,inactive,banned',
		]);

		$user->first_name = $request->input('first_name', $user->first_name);
		$user->middle_name = $request->input('middle_name', $user->middle_name);
		$user->last_name = $request->input('last_name', $user->last_name);
		$user->username = $request->input('username', $user->username);
		$user->email = $request->input('email', $user->email);
		if ($request->filled('password')) {
			$user->password = Hash::make($request->input('password'));
		}
		$user->phone_number = $request->input('phone_number', $user->phone_number);
		$user->address = $request->input('address', $user->address);
		$user->position = $request->input('position', $user->position);
		$user->status = $request->input('status', $user->status ?? 'active');

		// Resolve role_id from roles table when a position/role name is selected
		$roleId = null;
		if (!empty($user->position)) {
			$roleId = DB::table('roles')->where('name', $user->position)->value('id');
		}
		$user->role_id = $roleId;

		$user->save();

		return redirect()->route('admin.users')->with('success', 'User updated.');
	}
}

