<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $recipient_first_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($code, $recipient_first_name)
    {
        $this->code = $code;
        $this->recipient_first_name = $recipient_first_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.passwordreset');
    }
}
