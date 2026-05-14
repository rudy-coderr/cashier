<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\MakerController;
use App\Http\Controllers\AccountantController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
	return view('landingpage.landingpage');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
// Password reset (forgot password) routes
Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
Route::get('/login/otp', [App\Http\Controllers\LoginController::class, 'showOtpForm'])->name('auth.otp.show');
Route::post('/login/otp', [App\Http\Controllers\LoginController::class, 'verifyOtp'])->name('auth.otp.verify');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
	return redirect()->route('dashboard');
});





Route::middleware(['auth', \App\Http\Middleware\RequireRole::class . ':maker'])->group(function () {
	// Maker dashboard (protected)
	Route::get('/maker', [MakerController::class, 'index'])->name('dashboard');
	// Handle payment form submissions from the dashboard (now served at /maker)
	Route::post('/maker', [MakerController::class, 'store'])->name('dashboard.store')->middleware(\App\Http\Middleware\LogUserActivity::class);

// Payments flow (handled by MakerController)
Route::get('/payments', [MakerController::class, 'listPayments'])->name('payments.index');
// JSON endpoint for AJAX requests
Route::get('/payments.json', [MakerController::class, 'paymentsJson'])->name('payments.json');
Route::get('/payments/create', [MakerController::class, 'createPayment'])->name('payments.create');
Route::post('/payments', [MakerController::class, 'store'])->name('payments.store')->middleware(\App\Http\Middleware\LogUserActivity::class);
});

// Accountant routes (require authenticated accountant)
Route::middleware(['auth', \App\Http\Middleware\RequireRole::class . ':accountant'])->group(function () {
    Route::get('/accountant/approved', [AccountantController::class, 'approved'])->name('accountant.approved');
	Route::get('/accountant/approval', [AccountantController::class, 'approval'])->name('accountant.approval');
	// Accountant profile
	Route::get('/accountant/profile', [AccountantController::class, 'profile'])->name('accountant.profile');
	Route::patch('/accountant/profile', [AccountantController::class, 'updateProfile'])->name('accountant.profile.update');
	Route::patch('/accountant/profile/password', [AccountantController::class, 'updatePassword'])->name('accountant.profile.password');
	Route::post('/accountant/approval/{id}/approve', [AccountantController::class, 'approve'])->name('accountant.approve');
	Route::post('/accountant/approval/{id}/reject', [AccountantController::class, 'reject'])->name('accountant.reject');
});


// Admin routes (require authenticated admin)
Route::middleware(['auth', \App\Http\Middleware\RequireRole::class . ':admin'])->group(function () {
	// Admin dashboard
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

	// Profile routes handled by AdminController
Route::get('/profile', [AdminController::class, 'profile'])->name('profile')->middleware('auth');
Route::patch('/profile', [AdminController::class, 'updateProfile'])->name('profile.update')->middleware('auth');
Route::patch('/profile/password', [AdminController::class, 'updatePassword'])->name('profile.password')->middleware('auth');
});

// Reviewer routes (require authenticated reviewer)
Route::middleware(['auth', \App\Http\Middleware\RequireRole::class . ':reviewer'])->group(function () {
	Route::get('/reviewer', [ReviewerController::class, 'index'])->name('reviewer');
	Route::put('/payments/{id}', [ReviewerController::class, 'update'])->name('payments.update')->middleware(\App\Http\Middleware\LogUserActivity::class);
	// Reviewer forwards payments to Accountant for final approval
	Route::post('/payments/{id}/forward', [ReviewerController::class, 'forward'])->name('payments.forward');
	Route::get('/payments/next-op', [ReviewerController::class, 'nextOpNumber'])->name('payments.next-op');
});


