<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountantController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewerController;

Route::get('/', function () {
	return view('landingpage.landingpage');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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


