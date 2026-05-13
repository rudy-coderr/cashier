<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\OneTimePassword;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /**
     * Show the login page.
     */
    public function index()
    {
        return view('login.login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $throttleKey = Str::lower($request->input('email')).'|'.$request->ip();
        $maxAttempts = 5;
        $decaySeconds = 60 * 5; // 5 minutes

        if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = (int) ceil($seconds / 60);

            return back()->withErrors([
                'email' => "Too many login attempts. Please try again in {$minutes} minute(s).",
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Credentials correct — create OTP, email it, and ask user to verify.
            $user = Auth::user();

            // generate 6-digit numeric OTP
            $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // store OTP in cache keyed by user id for 5 minutes
            Cache::put('login_otp_'.$user->id, $otp, now()->addMinutes(5));

            // store pending user id and remember flag in session
            session(['pending_login_user' => $user->id, 'pending_login_remember' => $request->filled('remember')]);

            try {
                Log::info('Attempting to send OTP email', ['email' => $user->email, 'user_id' => $user->id]);
                Mail::to($user->email)->send(new OneTimePassword($otp, $user));
                Log::info('OTP email sent', ['email' => $user->email, 'user_id' => $user->id]);
            } catch (\Throwable $e) {
                Log::error('Failed to send OTP email: '.$e->getMessage(), ['user_id' => $user->id]);
            }

            // logout temporary authentication so full login waits for OTP
            Auth::logout();

            return redirect()->route('auth.otp.show');
        }

        // increment attempts
        RateLimiter::hit($throttleKey, $decaySeconds);
        $attemptsLeft = $maxAttempts - RateLimiter::attempts($throttleKey);

        $message = 'The provided credentials do not match our records.';
        if ($attemptsLeft > 0) {
            $message .= " You have {$attemptsLeft} attempt(s) remaining.";
        } else {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = (int) ceil($seconds / 60);
            $message = "Too many login attempts. Please try again in  {$minutes} minute(s).";
        }

        return back()->withErrors([
            'email' => $message,
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        try {
            if ($user) {
                AuditLog::create([
                    'user_id' => $user->id,
                    'action' => 'logout',
                    'description' => 'User logged out',
                    'ip_address' => $request->ip(),
                ]);
            }
        } catch (\Throwable $e) {
            // ignore
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out.');
    }


    /**
     * Show OTP verification form.
     */
    public function showOtpForm()
    {
        return view('auth.otp');
    }

    /**
     * Verify submitted OTP and finalize login.
     */
    public function verifyOtp(Request $request)
    {
        $data = $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $userId = session('pending_login_user');
        $remember = session('pending_login_remember', false);

        if (! $userId) {
            return redirect()->route('login')->with('error', 'No pending login found.');
        }

        $cached = Cache::get('login_otp_'.$userId);
        if (! $cached || $cached !== $data['otp']) {
            return back()->withErrors(['otp' => 'Invalid or expired code.'])->withInput();
        }

        // OTP valid — remove it and authenticate the user
        Cache::forget('login_otp_'.$userId);
        session()->forget(['pending_login_user','pending_login_remember']);

        Auth::loginUsingId($userId, $remember);

        // Log successful login
        try {
            $user = Auth::user();
            AuditLog::create([
                'user_id' => $user->id,
                'action' => 'login',
                'description' => 'User logged in (OTP)',
                'ip_address' => $request->ip(),
            ]);
        } catch (\Throwable $e) { /* silent */ }

        // redirect based on role/position (reuse same logic as login)
        $roleName = null;
        if (! empty(Auth::user()->role_id)) {
            $roleName = DB::table('roles')->where('id', Auth::user()->role_id)->value('name');
        }
        $role = strtolower($roleName ?? '');
        $position = strtolower(Auth::user()->position ?? '');

        if ($role === 'accountant' || $position === 'accountant') {
            return redirect()->intended(route('accountant.approval'));
        }
        if ($role === 'maker' || $position === 'maker') {
            return redirect()->intended(route('dashboard'));
        }
        if ($role === 'admin' || $position === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }
        if ($role === 'reviewer' || $position === 'reviewer') {
            return redirect()->intended(route('reviewer'));
        }

        return redirect()->intended(route('dashboard'));
    }
}
