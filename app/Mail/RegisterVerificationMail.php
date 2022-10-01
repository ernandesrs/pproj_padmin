<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User $user
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.register-verification')
            ->subject("[" . config("app.name") . "] Verificação de conta")
            ->to($this->user->email, $this->user->first_name . " " . $this->user->last_name)
            ->with([
                'name' => $this->user->first_name,
                'gender' => $this->user->gender,
                'verificationLink' => route('auth.verify', [
                    'token' => base64_encode($this->user->confirmation_token . '|' . time())
                ])
            ]);
    }
}
