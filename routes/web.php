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
Route::post('/dashboard', [DashboardController::class, 'store'])->name('dashboard.store');

// Payments flow (handled by DashboardController)
Route::get('/payments', [DashboardController::class, 'listPayments'])->name('payments.index');
// JSON endpoint for AJAX requests
Route::get('/payments.json', [DashboardController::class, 'paymentsJson'])->name('payments.json');
Route::get('/payments/create', [DashboardController::class, 'createPayment'])->name('payments.create');
Route::post('/payments', [DashboardController::class, 'store'])->name('payments.store');


// Accountant routes
Route::get('/accountant/approval', [AccountantController::class, 'approval'])->name('accountant.approval');
Route::post('/accountant/approval/{id}/approve', [AccountantController::class, 'approve'])->name('accountant.approve');
Route::post('/accountant/approval/{id}/reject', [AccountantController::class, 'reject'])->name('accountant.reject');


// Admin route
Route::get('/admin', [AdminController::class, 'index'])->name('admin');

// Reviewer route
Route::get('/reviewer', [ReviewerController::class, 'index'])->name('reviewer');
Route::put('/payments/{id}', [ReviewerController::class, 'update'])->name('payments.update');
// Reviewer actions for payments (approve / reject)
Route::post('/payments/{id}/approve', [ReviewerController::class, 'approve'])->name('payments.approve');
Route::post('/payments/{id}/reject', [ReviewerController::class, 'reject'])->name('payments.reject');
Route::get('/payments/next-op', [ReviewerController::class, 'nextOpNumber'])->name('payments.next-op');


