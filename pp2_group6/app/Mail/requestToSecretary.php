<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class requestToSecretary extends Mailable
{
    use Queueable, SerializesModels;
    public $requestToSecretary;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($requestToSecretary)
    {
        $this->requestToSecretary = $requestToSecretary;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Appointment Request')->view('email.requestToSecretaryMail');
    }
}
