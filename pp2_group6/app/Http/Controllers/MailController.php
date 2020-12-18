<?php

namespace App\Http\Controllers;
use App\Mail\AlMail;
use App\Mail\cancelMail;
use App\Mail\AcceptMail;
use App\Mail\RefuseMail;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Mail;

class MailController extends Controller
{
   public function signalRequestMail(Request $request){
       
        //If there is some problem in the page, the secretary can signal it us
        //Get an object with the title and the description 
       $details = [
           'title' => 'Alert in site',
           'description' => $request['description'],
       ];

       //Sends an email to developers with OBJECT $details
       Mail::to("secretary.ehb@gmail.com")->send(new AlMail($details));
       return "Email sent";
   }
   

    //Deletes an appointment based on the ID
   public function deleteConfirmedAppointment($appointmentId)
   {
       
        //Search in Appointment model where appointmentid = appointmentid 
    if (Appointment::find($appointmentId) )
    {
        //If you find the ID, delete the appointment
        $appointment=Appointment::where('appointmentId', '=' , $appointmentId)->delete();

        return response()->json($appointment);
    }
    else
    {
        //if the appointment is not found, delete the appointment
        $errorMessage = "Appointment Not Found!";
        return response()->json($errorMessage);
    }

   }
   // CANCEL
   public function deleteAppointment(Request $request)
   {
       //get User
         $user = Auth::user();
         $secretaryFirstName = $user['firstName'];
         $secretaryLastName = $user['lastName'];
         $secretaryName = $secretaryFirstName . ' ' . $secretaryLastName;

         //Request
        $description = $request['description'];
        $appointmentId = $request['id'];

        //information of student and appointment
        $information =  Appointment::select('students.firstName', 'students.lastName', 'appointments.startsAt', 'appointments.date') 
        ->join('students', 'students.student_id', '=', 'appointments.student_id')
        ->where('appointments.appointmentId' , $appointmentId)
        ->get();
        $studentFirstName = $information[0]['firstName'];
        $studentLastName = $information[0]['lastName'];
        $time = $information[0]['startsAt'];
        $date = $information[0]['date'];
        $fullName = $studentFirstName . ' ' . $studentLastName;
        $appointment = $date . ' at ' . $time;

        //Get mail of the student
        $mail = DB::table('appointments')
        ->join('students', 'students.student_id', '=', 'appointments.student_id')
        ->select('students.email')
        ->where('appointments.appointmentId' , $appointmentId)
        ->get();

        //Get all the data in a object
        $cancel = [
            'title' => 'Appointment cancelled',
            'description' => $request['description'],
            'name' => $fullName,
            'appointment' => $appointment,
            'secretary' => $secretaryName,
        ];

        //Sent mail with the cancel information
        Mail::to($mail)->send(new cancelMail($cancel));

        //Get delete function that let you delete the appointment if it is cancelled
        $this->deleteConfirmedAppointment($appointmentId);

        //Return "Email sent";
        return response($request);
    }

    
    public function acceptMail($appointmentId){
      //get User
      $user = Auth::user();
      $secretaryFirstName = $user['firstName'];
      $secretaryLastName = $user['lastName'];
      $secretaryName = $secretaryFirstName . ' ' . $secretaryLastName;

     //take data from database
     $information =  Appointment::select('students.firstName', 'students.lastName', 'appointments.startsAt', 'appointments.date', 'appointments.cancelToken' ) 
     ->join('students', 'students.student_id', '=', 'appointments.student_id')
     ->where('appointments.appointmentId' , $appointmentId)
     ->get();
     $studentFirstName = $information[0]['firstName'];
     $studentLastName = $information[0]['lastName'];
     $time = $information[0]['startsAt'];
     $date = $information[0]['date'];
     $fullName = $studentFirstName . ' ' . $studentLastName;
     $appointment = $date . ' at ' . $time;
     $tokenNumber = $information[0]['cancelToken'];
     $token = 'localhost:8000/' . $tokenNumber;

    //Get mail of the student
     $mail = DB::table('appointments')
     ->join('students', 'students.student_id', '=', 'appointments.student_id')
     ->select('students.email')
     ->where('appointments.appointmentId' , $appointmentId)
     ->get();

   
       
        
    //Get all the data in a object
     $accept = [
     'title' => 'Appointment accepted',
     'name' => $fullName,
     'appointment' => $appointment,
     'token' => $token,
     'secretary' => $secretaryName,
     ];

    //Sent mail with the information
     Mail::to($mail)->send(new AcceptMail($accept));

    // return "Email sent";
      return "Email sent";
    }

 //Change status of appointment to 'confirmed'
 public function updateConfirmed($appointmentId){
  
    if (Appointment::find($appointmentId))
        {
            // If appointment is found -> change the status from 'pending' to 'confirmed' when you click on the accept button
            $appointment=Appointment::find($appointmentId)->update(['status' => 'confirmed']);

            $this->acceptMail($appointmentId);
            
            return response()->json($appointment);
        }
        else
        {
            $errorMessage = "Appointment Not Found!";
            return response()->json($errorMessage);
        }
    }

 
    public function refuseMail($appointmentId){

        //get User
        $user = Auth::user();
        $secretaryFirstName = $user['firstName'];
        $secretaryLastName = $user['lastName'];
        $secretaryName = $secretaryFirstName . ' ' . $secretaryLastName;
        
        //take data from database
        $information =  Appointment::select('students.firstName', 'students.lastName', 'appointments.startsAt', 'appointments.date') 
        ->join('students', 'students.student_id', '=', 'appointments.student_id')
        ->where('appointments.appointmentId' , $appointmentId)
        ->get();
        $studentFirstName = $information[0]['firstName'];
        $studentLastName = $information[0]['lastName'];
        $time = $information[0]['startsAt'];
        $date = $information[0]['date'];
        $fullName = $studentFirstName . ' ' . $studentLastName;
        $appointment = $date . ' at ' . $time;
    
        //get mail of the student
        $mail = DB::table('appointments')
        ->join('students', 'students.student_id', '=', 'appointments.student_id')
        ->select('students.email')
        ->where('appointments.appointmentId' , $appointmentId)
         ->get();            
            
        //Get all the data in a object
       $refuse = [
        'title' => 'Appointment refused',
        'name' => $fullName,
        'appointment' => $appointment,
        'secretary' => $secretaryName,
        ];
        //Sent mail with the information
        Mail::to($mail)->send(new RefuseMail($refuse));

        // return "Email sent";
        return "Email sent";
        }
    

    //Change status of appointment to 'refused'
    public function updateRefused($appointmentId){
        if (Appointment::find($appointmentId))
        {
            // If appointment is found -> change the status from 'pending' to 'refused' when you click on the accept button
            $appointment=Appointment::find($appointmentId)->update(['status' => 'refused']);
            $this->refuseMail($appointmentId);
            return response()->json($appointment);
        }
        else
        {
            $errorMessage = "Appointment Not Found!";
            return response()->json($errorMessage);
        }
    }
 



}
