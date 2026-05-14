<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordMail extends Mailable
{
    use SerializesModels;

    public $token;
    public $user;

    public function __construct($token, $user)
    {
        $this->token = $token;
        $this->user = $user;
    }

    public function build()
    {
        $url = url(route('password.reset', ['token' => $this->token, 'email' => $this->user->email], false));

        return $this->subject('Reset your password')
                    ->view('emails.password_reset')
                    ->with(['url' => $url, 'user' => $this->user]);
    }
}
