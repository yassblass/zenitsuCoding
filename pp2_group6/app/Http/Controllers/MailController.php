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
    //Sends an email to the developers when someone clicks on the Alert button 
    public function sendAlert(Request $request){
        //Make an object with the title and the description 
       $details = [
           'title' => 'Alert in site',
           'description' => $request['description'],
       ];

       //Sends an email to developers with OBJECT $details
       Mail::to("secretary.ehb@gmail.com")->send(new AlMail($details));
       return "Email sent";
    }


    //Deletes an appointment based on the ID
   public function deleteAppointment($appointmentId)
   {
        //Find the appointment based on its ID
        if (Appointment::find($appointmentId))
        {
            //If ID is found, delete the appointment
            $appointment=Appointment::find($appointmentId)->delete();

            return response()->json($appointment);
        }
        else
        {
            //If ID is not found, send error message
            $errorMessage = "Appointment Not Found!";
            return response()->json($errorMessage);
        }
   }




   public function cancelAppointment(Request $request)
   {
        
        $description = $request['description'];
        $appointmentId = $request['id'];

        //Get mail of the student
        $mail = DB::table('appointments')
        ->join('students', 'students.student_id', '=', 'appointments.student_id')
        ->select('students.email')
        ->where('appointments.appointmentId' , $appointmentId)
        ->get();

        //Get firstname of the student
        $studentName =  DB::table('appointments')
        ->join('students', 'students.student_id', '=', 'appointments.student_id')
        ->select('students.firstName')
        ->where('appointments.appointmentId' , $appointmentId)
        ->get();

        //Get lastname of the student
        $studentLast = DB::table('appointments')
        ->join('students', 'students.student_id', '=', 'appointments.student_id')
        ->select('students.lastName')
        ->where('appointments.appointmentId' , $appointmentId)
        ->get();

        //Get appointment date
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

        //Sent mail with the cancel information
        Mail::to($mail)->send(new cancelMail($cancel));

        //Get delete function that let you delete the appointment if it is cancelled
        $this->deleteAppointment($appointmentId);

        //Return "Email sent";
        return response($request);
    }
}


