<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountantController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

Route::get('/', function () {
	return view('landingpage.landingpage');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Simple profile route used by admin views
Route::get('/profile', function () {
	return view('admin.profile');
})->name('profile');

// Update profile (basic fields)
Route::patch('/profile', function (Request $request) {
	$user = $request->user();
	$data = $request->validate([
		'first_name' => 'sometimes|string|max:191',
		'middle_name' => 'sometimes|string|max:191|nullable',
		'last_name' => 'sometimes|string|max:191',
		'email' => 'required|email|max:191|unique:users,email,'.$user->id,
		'phone_number' => 'sometimes|string|nullable',
		'address' => 'sometimes|string|nullable',
	]);

	$user->first_name = $request->input('first_name', $user->first_name);
	$user->middle_name = $request->input('middle_name', $user->middle_name);
	$user->last_name = $request->input('last_name', $user->last_name);
	$user->email = $request->input('email', $user->email);
	$user->phone_number = $request->input('phone_number', $user->phone_number);
	$user->address = $request->input('address', $user->address);
	$user->save();

	return redirect()->route('profile')->with('success', 'Profile updated.');
})->name('profile.update')->middleware('auth');

// Change password
Route::patch('/profile/password', function (Request $request) {
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
})->name('profile.password')->middleware('auth');

// Handle payment form submissions from the dashboard
Route::post('/dashboard', [DashboardController::class, 'store'])->name('dashboard.store')->middleware(\App\Http\Middleware\LogUserActivity::class);

// Payments flow (handled by DashboardController)
Route::get('/payments', [DashboardController::class, 'listPayments'])->name('payments.index');
// JSON endpoint for AJAX requests
Route::get('/payments.json', [DashboardController::class, 'paymentsJson'])->name('payments.json');
Route::get('/payments/create', [DashboardController::class, 'createPayment'])->name('payments.create');
Route::post('/payments', [DashboardController::class, 'store'])->name('payments.store')->middleware(\App\Http\Middleware\LogUserActivity::class);


// Accountant routes
Route::get('/accountant/approval', [AccountantController::class, 'approval'])->name('accountant.approval');
Route::post('/accountant/approval/{id}/approve', [AccountantController::class, 'approve'])->name('accountant.approve');
Route::post('/accountant/approval/{id}/reject', [AccountantController::class, 'reject'])->name('accountant.reject');


// Admin route
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

// Admin: export users CSV
Route::get('/admin/users/export', [AdminController::class, 'exportUsers'])->name('admin.users.export');

// Admin: users list page
Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');

// Admin: view single user
Route::get('/admin/users/{id}', [AdminController::class, 'show'])->name('admin.users.show');

// Admin: audit logs
Route::get('/admin/auditlogs', [AdminController::class, 'auditlogs'])->name('admin.auditlogs');

// Admin: transaction history (previously reports)
Route::get('/admin/history', [AdminController::class, 'reports'])->name('admin.history');

// Admin: user management routes
Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.users.store')->middleware(\App\Http\Middleware\LogUserActivity::class);
// Admin: update user
Route::patch('/admin/users/{id}', [AdminController::class, 'update'])->name('admin.users.update')->middleware(\App\Http\Middleware\LogUserActivity::class);
Route::post('/admin/users/{id}/toggle', [AdminController::class, 'toggle'])->name('admin.users.toggle')->middleware(\App\Http\Middleware\LogUserActivity::class);
Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy')->middleware(\App\Http\Middleware\LogUserActivity::class);

// Admin: transaction history generate
Route::post('/admin/history/generate', [AdminController::class, 'generateReport'])->name('admin.history.generate')->middleware(\App\Http\Middleware\LogUserActivity::class);

// Reviewer route
Route::get('/reviewer', [ReviewerController::class, 'index'])->name('reviewer');
Route::put('/payments/{id}', [ReviewerController::class, 'update'])->name('payments.update')->middleware(\App\Http\Middleware\LogUserActivity::class);
	// Reviewer forwards payments to Accountant for final approval
	Route::post('/payments/{id}/forward', [ReviewerController::class, 'forward'])->name('payments.forward');
Route::get('/payments/next-op', [ReviewerController::class, 'nextOpNumber'])->name('payments.next-op');


