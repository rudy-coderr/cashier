<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Models\AuditLog;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $throttleKey  = Str::lower($request->input('email')).'|'.$request->ip();
        $maxAttempts  = 5;
        $decaySeconds = 60 * 5;

        if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = (int) ceil($seconds / 60);
            return back()->withErrors([
                'email' => "Too many login attempts. Please try again in {$minutes} minute(s).",
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            try {
                AuditLog::create([
                    'user_id'     => $user->id,
                    'action'      => 'login',
                    'description' => 'User logged in',
                    'ip_address'  => $request->ip(),
                ]);
            } catch (\Throwable $e) { /* silent */ }

            return redirect()->intended(route($user->dashboardRoute()));
        }

        RateLimiter::hit($throttleKey, $decaySeconds);
        $attemptsLeft = $maxAttempts - RateLimiter::attempts($throttleKey);

        $message = 'The provided credentials do not match our records.';
        if ($attemptsLeft > 0) {
            $message .= " You have {$attemptsLeft} attempt(s) remaining.";
        } else {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = (int) ceil($seconds / 60);
            $message = "Too many login attempts. Please try again in {$minutes} minute(s).";
        }

        return back()->withErrors(['email' => $message])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        try {
            if ($user) {
                AuditLog::create([
                    'user_id'     => $user->id,
                    'action'      => 'logout',
                    'description' => 'User logged out',
                    'ip_address'  => $request->ip(),
                ]);
            }
        } catch (\Throwable $e) { /* ignore */ }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out.');
    }

    public function showOtpForm()
    {
        return view('auth.otp');
    }

    public function verifyOtp(Request $request)
    {
        $data = $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $userId   = session('pending_login_user');
        $remember = session('pending_login_remember', false);

        if (! $userId) {
            return redirect()->route('login')->with('error', 'No pending login found.');
        }

        $cached = Cache::get('login_otp_'.$userId);
        if (! $cached || $cached !== $data['otp']) {
            return back()->withErrors(['otp' => 'Invalid or expired code.'])->withInput();
        }

        Cache::forget('login_otp_'.$userId);
        session()->forget(['pending_login_user', 'pending_login_remember']);

        Auth::loginUsingId($userId, $remember);

        $user = Auth::user();

        try {
            AuditLog::create([
                'user_id'     => $user->id,
                'action'      => 'login',
                'description' => 'User logged in (OTP)',
                'ip_address'  => $request->ip(),
            ]);
        } catch (\Throwable $e) { /* silent */ }

        return redirect()->intended(route($user->dashboardRoute()));
    }
}
