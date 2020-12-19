<?php

namespace App\Http\Controllers;

use App\Mail\AlMail;
use App\Mail\cancelMail;
use App\Mail\requestMail;
use App\Mail\verificationCode;
use App\Models\Student;
use App\Models\Verification;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Mail;



class MailController extends Controller
{
    //Sends an email to the developers when someone clicks on the Alert button 
    public function sendAlert(Request $request)
    {
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
        if (Appointment::find($appointmentId)) {
            //If ID is found, delete the appointment
            $appointment = Appointment::find($appointmentId)->delete();

            return response()->json($appointment);
        } else {
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
            ->where('appointments.appointmentId', $appointmentId)
            ->get();

        //Get firstname of the student
        $studentName =  DB::table('appointments')
            ->join('students', 'students.student_id', '=', 'appointments.student_id')
            ->select('students.firstName')
            ->where('appointments.appointmentId', $appointmentId)
            ->get();

        //Get lastname of the student
        $studentLast = DB::table('appointments')
            ->join('students', 'students.student_id', '=', 'appointments.student_id')
            ->select('students.lastName')
            ->where('appointments.appointmentId', $appointmentId)
            ->get();

        //Get appointment date
        $appoint = DB::table('appointments')
            ->join('students', 'students.student_id', '=', 'appointments.student_id')
            ->select('appointments.startsAt')
            ->where('appointments.appointmentId', $appointmentId)
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


    public function sendCode(Request $request)
    {

        //generate random 6 digits code
        $v_code = mt_rand(100000, 999999);

        //isolate student name based on id.
        $firstname = $request['student_firstName'];
        $lastname = $request['student_lastName'];

        //isolate student ID based on full name.
        $matchTese = ['firstName' => $firstname, 'lastName' => $lastname];
        $student = Student::select('student_id', 'email')->where($matchTese)->get();
        $student_id = $student[0]['student_id'];
        $student_email = $student[0]['email'];


        //insert generated verification code into DB table 'verifications'

        $timeNow = Carbon::now()->addMinutes(5);
        $timeNow = $timeNow->format('Y/m/d H:i:s');
        //$dateNow = date('Y-m-d H:i:s');

        if (Verification::create(array(
            'student_id' => $student_id,
            'vc' => $v_code,
            'expiresAt' => $timeNow,
        ))) {
            $verificationCode = array(
                'firstname' => $firstname,
                'lastname' => $lastname,
                'v_code' => $v_code,
            );

            //Send mail to student containing generated verification code which will be deleted after it expires.
            Mail::to($student_email)->send(new verificationCode($verificationCode));
        }



        //return response for testing purposes.
        return response($student);
    }
}
