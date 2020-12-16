<?php

namespace App\Http\Controllers;
use App\Mail\AlMail;
use App\Mail\cancelMail;
use App\Mail\AcceptMail;
use App\Mail\RefuseMail;



use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Mail;




class MailController extends Controller
{




   public function sendAlert(Request $request){
       
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
   //DELETE

   public function deleteAppointment($appointmentId)
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

   public function cancelAppointment(Request $request)
   {
        
        $description = $request['description'];
        $appointmentId = $request['id'];

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

        //Get firstname of the student
        // $studentFirstName =  DB::table('appointments')
        // ->join('students', 'students.student_id', '=', 'appointments.student_id')
        // ->select('students.firstName')
        // ->where('appointments.appointmentId' , $appointmentId)
        // ->get();

        // //Get lastname of the student
        // $studentLastName = DB::table('appointments')
        // ->join('students', 'students.student_id', '=', 'appointments.student_id')
        // ->select('students.lastName')
        // ->where('appointments.appointmentId' , $appointmentId)
        // ->get();

        // //Get appointment date
        // $appoint = DB::table('appointments')
        // ->join('students', 'students.student_id', '=', 'appointments.student_id')
        // ->select('appointments.startsAt')
        // ->where('appointments.appointmentId' , $appointmentId)
        // ->get();

        // //Get appointment date
        // $date = DB::table('appointments')
        // ->join('students', 'students.student_id', '=', 'appointments.student_id')
        // ->select('appointments.date')
        // ->where('appointments.appointmentId' , $appointmentId)
        // ->get()
        //Get all the data in a object
        $cancel = [
            'title' => 'Appointment cancelled',
            'description' => $request['description'],
            'name' => $fullName,
            'appointment' => $appointment,
        ];

        //Sent mail with the cancel information
        Mail::to($mail)->send(new cancelMail($cancel));

        //Get delete function that let you delete the appointment if it is cancelled
        $this->deleteAppointment($appointmentId);

        //Return "Email sent";
        return response($request);
    }

    
    public function acceptMail($appointmentId){

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

        //Get mail of the student
        $mail = DB::table('appointments')
        ->join('students', 'students.student_id', '=', 'appointments.student_id')
        ->select('students.email')
        ->where('appointments.appointmentId' , $appointmentId)
        ->get();

    // //get firstname of the student
    //  $studentName =  DB::table('appointments')
    //  ->join('students', 'students.student_id', '=', 'appointments.student_id')
    //  ->select('students.firstName')
    //  ->where('appointments.appointmentId' , $appointmentId)
    //   ->get();

    //   //get lastname of the student
    //   $studentLast = DB::table('appointments')
    //   ->join('students', 'students.student_id', '=', 'appointments.student_id')
    //   ->select('students.lastName')
    //   ->where('appointments.appointmentId' , $appointmentId)
    //    ->get();

    //     //get appointment date
    //    $appoint = DB::table('appointments')
    //    ->join('students', 'students.student_id', '=', 'appointments.student_id')
    //    ->select('appointments.startsAt')
    //    ->where('appointments.appointmentId' , $appointmentId)
    //     ->get();
        //get token
        $token = DB::table('appointments')
        ->join('students', 'students.student_id', '=', 'appointments.student_id')
        ->select('appointments.cancelToken')
        ->where('appointments.appointmentId' , $appointmentId)
         ->get();
        
        
        //Get all the data in a object

       $accept = [
        'title' => 'Appointment accepted',
        'name' => $fullName,
        'appointment' => $appointment,
        'token' => $token,
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
    
        // //get firstname of the student
        //  $studentName =  DB::table('appointments')
        //  ->join('students', 'students.student_id', '=', 'appointments.student_id')
        //  ->select('students.firstName')
        //  ->where('appointments.appointmentId' , $appointmentId)
        //   ->get();
    
        //   //get lastname of the student
        //   $studentLast = DB::table('appointments')
        //   ->join('students', 'students.student_id', '=', 'appointments.student_id')
        //   ->select('students.lastName')
        //   ->where('appointments.appointmentId' , $appointmentId)
        //    ->get();
    
        //     //get appointment date
        //    $appoint = DB::table('appointments')
        //    ->join('students', 'students.student_id', '=', 'appointments.student_id')
        //    ->select('appointments.startsAt')
        //    ->where('appointments.appointmentId' , $appointmentId)
        //     ->get();
            //get token
            $token = DB::table('appointments')
            ->join('students', 'students.student_id', '=', 'appointments.student_id')
            ->select('appointments.cancelToken')
            ->where('appointments.appointmentId' , $appointmentId)
             ->get();
            
            
            //Get all the data in a object
    
           $refuse = [
            'title' => 'Appointment refused',
            'name' => $fullName,
            'appointment' => $appointment,
            'token' => $token,
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
