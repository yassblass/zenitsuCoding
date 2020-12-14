<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AlMail extends Mailable
{
     //Alert Mail if there is a problem detected n the site
     use Queueable, SerializesModels;

     //details comes from MailController, it is the object that is send in the return from formSubmit()
     public $details;
 
 
     /**
      * Create a new message instance.
      *
      * @return void
      */
     public function __construct($details)
     {
         $this->details = $details;
     }
 
     /**
      * Build the message.
      *
      * @return $this
      */
     public function build()
     {
         //The subject of the mail is : Problem detected on the site
         //The view is email.AlertMail is the template of the mail that will be sent
         return $this->subject('Problem detected on the site')->view('email.AlertMail');
     }
}
