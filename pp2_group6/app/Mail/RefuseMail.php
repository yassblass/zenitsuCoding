<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RefuseMail extends Mailable
{
    use Queueable, SerializesModels;
    public $refuse;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($refuse)
    {
        $this->refuse = $refuse;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Appointment refused')->view('email.RefuseMail');

    }
}
