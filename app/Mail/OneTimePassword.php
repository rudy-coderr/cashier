<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OneTimePassword extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $user;

    public function __construct(string $otp, $user = null)
    {
        $this->otp = $otp;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Your one-time login code')
                    ->view('emails.one_time_password')
                    ->with(['otp' => $this->otp, 'user' => $this->user]);
    }
}
