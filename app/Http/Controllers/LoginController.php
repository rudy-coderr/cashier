<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

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
            $request->session()->regenerate();
            RateLimiter::clear($throttleKey);

            return redirect()->intended(route('dashboard'));
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
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out.');
    }
}
