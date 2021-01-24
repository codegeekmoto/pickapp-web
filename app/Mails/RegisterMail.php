<?php

namespace App\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterMail extends Mailable {

    use Queueable, SerializesModels;
    public $sender_full_name;
    public $recipient_first_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sender_full_name, $recipient_first_name)
    {
        $this->sender_full_name = $sender_full_name;
        $this->recipient_first_name = $recipient_first_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->recipient_first_name.', welcome to Pick App!')
                    ->view('emails.register');
    }

}