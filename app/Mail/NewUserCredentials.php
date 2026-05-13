<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class NewUserCredentials extends Mailable
{
    use Queueable, SerializesModels;

    /** @var User */
    public $user;

    /** @var string */
    public $password;

    public function __construct(User $user, string $plainPassword)
    {
        $this->user = $user;
        $this->password = $plainPassword;
    }

    public function build()
    {
        return $this->subject('Your Cashier account credentials')
                    ->view('emails.new_user_credentials')
                    ->with([
                        'user' => $this->user,
                        'password' => $this->password,
                    ]);
    }
}
