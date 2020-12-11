<?php

namespace App\Http\Controllers;
use App\Mail\AlMail;
use App\Mail\cancelMail;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
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

   public function cancelSubmit(Request $request){

    $mail = DB::table('appointments')
    ->join('students', 'students.student_id', '=', 'appointments.student_id')
    ->select('students.email')
     ->get();

       $cancel = [
           'title' => 'Appointment cancelled',
           'description' => $request['description'],
       ];

       Mail::to($mail)->send(new cancelMail($cancel));
       return "Email sent";
    }

 



}
