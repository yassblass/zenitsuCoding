<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class cancelMailToSecretary extends Mailable
{
    use Queueable, SerializesModels;
    public $cancelByStudent;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cancelByStudent)
    {
        $this->cancelByStudent = $cancelByStudent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Appointment Cancel')->view('email.cancelMailToSecretary');
    }
}
