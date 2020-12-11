<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class cancelMail extends Mailable
{
    use Queueable, SerializesModels;

    public $cancel;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cancel)
    {
         $this->cancel = $cancel;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->subject('Cancel Appointment')->view('email.cancelMail');
    }
}
