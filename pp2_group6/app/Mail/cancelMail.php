<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class cancelMail extends Mailable
{
    //Cancel mail if secretary want to cancel it -> So it is send a mail to the student
    use Queueable, SerializesModels;
    //cancel comes from MailController, it is the object that is send in the return from cancelSubmit()
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
        //The subject of the mail is : Your appointment is cancelled
        //The view is email.cancelMail is the template of the mail that will be sent
        
        return $this->subject('Your appointment is cancelled')->view('email.cancelMail');
    }
}
