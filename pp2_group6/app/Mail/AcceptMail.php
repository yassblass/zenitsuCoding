<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AcceptMail extends Mailable
{
    use Queueable, SerializesModels;

     //details comes from MailController, it is the object that is send in the return from acceptMail()
     public $accept;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($accept)
    {
         $this->accept = $accept;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Appointment Accepted')->view('email.AcceptMail');
    }
}
