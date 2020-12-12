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
       
        //If there is some problem in the page, the secretary can signal it us

        //Get an object with the title and the description 
       $details = [
           'title' => 'Alert in site',
           //Description is what the secretary write to tell us what the problemis
           'description' => $request['description'],
       ];

       //Send it to our mail with the object details 
       Mail::to("secretary.ehb@gmail.com")->send(new AlMail($details));
       return "Email sent";
   }

   public function deleteAppointment($appointmentId)
   {
       
        //Search in Appointment model where appointmentid = appointmentid 
    if (Appointment::find($appointmentId) )
    {
        //If you find the ID, delete the appointment
        $appointment=Appointment::find($appointmentId)->delete();

        return response()->json($appointment);
    }
    else
    {
        //if the appointment is not found, delete the appointment
        $errorMessage = "Appointment Not Found!";
        return response()->json($errorMessage);
    }

   }




   public function cancelSubmit(Request $request){

        // Descreption and id in cancel.vue
    $description = $request['description'];
    $appointmentId = $request['id'];


    //take data from database

    //get mail of the student
    $mail = DB::table('appointments')
    ->join('students', 'students.student_id', '=', 'appointments.student_id')
    ->select('students.email')
    ->where('appointments.appointmentId' , $appointmentId)
     ->get();

    //get firstname of the student
     $studentName =  DB::table('appointments')
     ->join('students', 'students.student_id', '=', 'appointments.student_id')
     ->select('students.firstName')
     ->where('appointments.appointmentId' , $appointmentId)
      ->get();

      //get lastname of the student
      $studentLast = DB::table('appointments')
      ->join('students', 'students.student_id', '=', 'appointments.student_id')
      ->select('students.lastName')
      ->where('appointments.appointmentId' , $appointmentId)
       ->get();

        //get appointment date
       $appoint = DB::table('appointments')
       ->join('students', 'students.student_id', '=', 'appointments.student_id')
       ->select('appointments.startsAt')
       ->where('appointments.appointmentId' , $appointmentId)
        ->get();
        
        
        //Get all the data in a object

       $cancel = [
           'title' => 'Appointment cancelled',
           'description' => $request['description'],
           'name' => $studentName,
           'lastname' => $studentLast,
           'appoint' => $appoint
       ];

       //Sent mail with the information
      Mail::to($mail)->send(new cancelMail($cancel));

       //Get delete function that let you delete the appointment if it is cancelled
      $this->deleteAppointment($appointmentId);

      // return "Email sent";
      return response($request);
    }

 



}
