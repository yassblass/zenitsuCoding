<?php

namespace App\Http\Controllers;
use App\Mail\AlMail;
use Illuminate\Http\Request;
use Mail;




class MailController extends Controller
{




   public function formSubmit(Request $request){
       $details = [
           'title' => 'Alert in site',
           'description' => $request['description'],
       ];

       Mail::to("secretary.ehb@gmail.com")->send(new AlMail($details));
       return "Email sent";
   }
}
