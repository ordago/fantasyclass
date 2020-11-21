<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportUser extends Mailable
{
    use Queueable, SerializesModels;

    public $messages;
    public $room;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($messages, $room)
    {
        $this->messages = $messages;
        $this->room = $room;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
                    ->view('mails.report');
    }
}
