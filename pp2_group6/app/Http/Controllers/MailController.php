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

   public function deleteAppointment($appointmentId)
   {
       

    if (Appointment::find($appointmentId) )
    {
        $appointment=Appointment::find($appointmentId)->delete();

        return response()->json($appointment);
    }
    else
    {
        $errorMessage = "Appointment Not Found!";
        return response()->json($errorMessage);
    }

   }




   public function cancelSubmit(Request $request){


    $description = $request['description'];
    $appointmentId = $request['id'];

    $mail = DB::table('appointments')
    ->join('students', 'students.student_id', '=', 'appointments.student_id')
    ->select('students.email')
    ->where('appointments.appointmentId' , $appointmentId)
     ->get();

     $studentName =  DB::table('appointments')
     ->join('students', 'students.student_id', '=', 'appointments.student_id')
     ->select('students.firstName')
     ->where('appointments.appointmentId' , $appointmentId)
      ->get();

      $studentLast = DB::table('appointments')
      ->join('students', 'students.student_id', '=', 'appointments.student_id')
      ->select('students.lastName')
      ->where('appointments.appointmentId' , $appointmentId)
       ->get();


       $appoint = DB::table('appointments')
       ->join('students', 'students.student_id', '=', 'appointments.student_id')
       ->select('appointments.startsAt')
       ->where('appointments.appointmentId' , $appointmentId)
        ->get();
 

       $cancel = [
           'title' => 'Appointment cancelled',
           'description' => $request['description'],
           'name' => $studentName,
           'lastname' => $studentLast,
           'appoint' => $appoint


       ];



       Mail::to($mail)->send(new cancelMail($cancel));

       $this->deleteAppointment($appointmentId);

      // return "Email sent";
      return response($request['description']);
    }

 



}
