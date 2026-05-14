<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use App\Models\User;

class PasswordResetController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // find user by email; if exists, generate token and send styled mail
        $user = User::where('email', $request->input('email'))->first();

        // to avoid leaking which emails exist, return success regardless
        if ($user) {
            $token = Password::broker()->createToken($user);
            try {
                Mail::to($user->email)->send(new ResetPasswordMail($token, $user));
            } catch (\Throwable $e) {
                // log but don't reveal to user
                \Log::error('Failed to send reset email: '.$e->getMessage());
            }
        }

        return back()->with('status', 'We have emailed your password reset link!');
    }

    public function showResetForm(\Illuminate\Http\Request $request, $token)
    {
        // pass email from query string (if present) so the form can be pre-filled
        return view('auth.passwords.reset', ['token' => $token, 'email' => $request->query('email')]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
