<?php

namespace App\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable {

    use Queueable, SerializesModels;
    public $sender_full_name;
    public $recipient_first_name;
    public $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sender_full_name, $recipient_first_name, $link)
    {
        $this->sender_full_name = $sender_full_name;
        $this->recipient_first_name = $recipient_first_name;
        $this->knoCard_link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->recipient_first_name.', welcome to Pick App!')
                    ->view('emails.welcome');
    }

}