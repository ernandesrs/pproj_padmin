<?php

namespace App\Mail;

use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecoveryPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * @var PasswordReset
     */
    public $passReset;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, PasswordReset $passReset)
    {
        $this->user = $user;
        $this->passReset = $passReset;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $token = base64_encode($this->passReset->email . '|' . $this->passReset->token);

        return $this->markdown('mails.recovery-password')
            ->to($this->user->email, $this->user->first_name . ' ' . $this->user->last_name)
            ->subject("["  . config("app.name") . "] Seu link de recuperação de senha")
            ->with([
                'name' => $this->user->first_name,
                'recoveryLink' => route('auth.reset', ['token' => $token])
            ]);
    }
}
