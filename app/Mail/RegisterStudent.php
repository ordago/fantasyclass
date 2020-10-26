<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterStudent extends Mailable
{
    use Queueable, SerializesModels;

      /**
     * The demo object instance.
     *
     * @var Demo
     */
    public $student;
    public $pass;
 
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($student, $pass)
    {
        $this->student = $student;
        $this->pass = $pass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
                    ->view('mails.student')
                    ->text('mails.student_plain');
    }
}
