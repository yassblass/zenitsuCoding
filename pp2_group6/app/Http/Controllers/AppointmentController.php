<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Student;
use Illuminate\Support\Facades\DB;


class AppointmentController extends Controller
{

    //Return to appointments page.
    public function getIndex(){
        return view('appointments');
    }

    //Get all appointments from DB.
    public function get(Request $request)
    {
        //Fetch all apointments from DB. Return true/false.
        if($appointments = Appointment::orderBy('created_at', 'asc')->get()) {

            return response($appointments);
        }
        else {
            return response(false);
        }
        
    }


    //Delete an appointment
    public function delete($appointmentId)
    {
        //Delete apointment from DB based on Appointment ID. Return true/false.
        if(Appointment::where('appointmentId', $appointmentId)->delete()) {

            return response(true);
            
        }   
        else {

            return response(false);
        }
        
    }

    
    //Cancel an appointment based on appointment ID.
    public function cancelAppointment($appointmentId)
    {
        
        //Performa  check to see if appointment got deleted.
        if(Appointment::find($appointmentId)->delete()) {

            //If TRUE, returns 1 to AXIOS CALL in Vue component called 'cancelPage'.
            return response(true);

        }else {

            //If FALSE, returns 0 to AXIOS CALL in Vue component called 'cancelPage'.
            return response(false);

        }

    }

    //Simple test function to return appointments.blade.php as a view.
    public function returnView(){

        return view('appointments');
    }


    //Show cancel page based on token.
    public function showCancelPage ($token){


        //8aa32d535944427a88ec2a75fe957aa387509c009cceda69b9a2d0f8450ea46f
        
        //Check if appointment exists with token.
        if (Appointment::where('cancelToken', '=', $token)) {

            //Simple check message for testing purposes.
            $check = "Appointment exists!";


            //Make empty appointment array template, will be used below.
            $appointment = array(
                'appointmentId' => '',
                'student_id' => '',
                'user_id' => '',
                'date' => '',
                'startsAt' => '',
                'subject' => '',
                'status' => '',
                'cancelToken' => '',
        );

            
            //Perform querybuilder, get appointment that is linked to given token.
            $getAppointment = Appointment::where('cancelToken', $token)->get();


            //Fill in appointment object with input data.
            $appointment[0] = $getAppointment[0]['appointmentId'];
            $appointment[1] = $getAppointment[0]['student_id'];
            $appointment[2] = $getAppointment[0]['user_id'];
            $appointment[3] = $getAppointment[0]['date'];
            $appointment[4] = $getAppointment[0]['startsAt'];
            $appointment[5] = $getAppointment[0]['subject'];
            $appointment[6] = $getAppointment[0]['status'];
            $appointment[7] = $getAppointment[0]['cancelToken'];


            //Passing appointment array to Vuejs gave errors, until error gets fixed, we send every param individually.
            $appointmentId = $appointment[0];
            $student_id = $appointment[1];
            $user_id = $appointment[2];
            $date = $appointment[3];
            $startsAt = $appointment[4];
            $subject = $appointment[5];
            $status = $appointment[6];
            $cancelToken = $appointment[7];
            

            //Convert result to JSON
            //$appointment = json_encode($appointment);

            //$name = $appointment[0]['firstName'] . ' ' . $appointment[0]['lastName'];

            //Return view called 'cancelPage' with appointment data.
            return view("cancelPage", compact('check','appointmentId','student_id','user_id','date','startsAt','subject','status','cancelToken'));
            
        }
        else{

            //IF appointment doesn't exist.
            $check = "Appointment doesn't exist!";


            //return view with only check message.
            return view("cancelPage", compact("check"));
        } 
    }



    //Make an appointment request
    public function makeRequest(Request $request)
    {
        //Declare needed varibales.
        //IsolateToken & Appointment object from request.
        $token = $request['token'];
        $appointment = $request['request'];
        $domain = '@student.ehb.be';
        $firstName = $appointment['firstName'];
        $lastName = $appointment['lastName'];
        $email = $firstName . '.' . $lastName . $domain;

        // //Since a first token is generated at the VueJS side, we hash it once more in the backend. Hashing technique used -> [sha256].
        $hashedToken = hash('sha256',$token);
        

        // //Check if given $email exist in DB
        $checkEmail = Student::where('email', '=', $email)->exists();

        // //Gives object with student_id based on given EMAIL () from DB
        $getStudentId = Student::select('student_id')->where('email', '=', $email)->get();

        //If email exists, create an appointment request.
        if($checkEmail){
            $appointment = Appointment::create(array(
                'student_id' => $getStudentId[0]->student_id,
                'user_id' => $appointment['user_id'],
                'date' => $appointment['date'],
                'startsAt' => $appointment['startsAt'],
                'subject' => $appointment['subject'],
                'status' => 'pending',
                'cancelToken' => $hashedToken,
            ));

            return response(true);
        }
        else
        {
            return response(false);
        } 

    }
    



    //Update an appointment
    public function updateAppointment(Request $request){

        //Here, the request contains a JSON object called 'appointment', containing every table entry needed to make a request.
        //Isolate appointment object & appointmentId from request.
        $content = $request['appointment'];
        $appointmentId = $content['appointmentId'];
        
        //return response($request);

        //VALIDATION
        // $data = request()->validate([
        //     'student_id' => '',
        //     'user_id' => '',
        //     'date' => 'date',
        //     'startsAt' => '',
        //     'subject' => '',
        //  ]);

        if (Appointment::find($appointmentId))
        {
            $appointment=Appointment::find($appointmentId)->update($content);

            return response(true);
        }
        else
        {
            $errorMessage = "Appointment Not Found!";
            return response(false);
        }
        
        

        return response()->json($content);
    }


    //Confirm an appointment based on id, changes the appointment status.
    public function confirmAppointment($appointmentId){
        

        //Check if appoint exists, then perform query.
        if (Appointment::find($appointmentId))
        {
            //Change appointment status to 'confirmed'.
            $appointment=Appointment::find($appointmentId)->update(['status' => 'confirmed']);
            
            //For testing purposes, we return the updated appointment.
            return response()->json($appointment);
        }
        else
        {
            //temporary error message variable.
            $errorMessage = "Appointment Not Found!";

            //Return eroor message to axios.
            return response()->json($errorMessage);
        }
        
    }


    //TEMPORARY FUNCTIONS, NOT IN USE YET.

    //temporary function
    public function encrypt($token) {

        $hashedToken = hash('sha256',$token);

        $appointment = Appointment::create(array(
        
            'student_id' => 2,
            'user_id' => 2,
            'date' => '2020-12-10',
            'startsAt' => '2020-12-10 16:02:54',
            'subject' => 'Subject',
            'status' => '',
            'cancelToken' => $hashedToken
            )
        );

    
          //$user = User::select('name')->where('id', 9)->get()->first();

        // $app = Appointment::create(
        //     array(
        //         'firstName' =>'Adil',
        //         'lastName' => 'Travlo',
        //         'secretary' => $user['name'],
        //         'day' =>'monday',
        //         'cancelToken' => $hashedToken
        //     )
        //);

        return response()->json($appointment);
    }


    //Temporary function
    public function store(Request $request) {
        //Here, the $request object containes 2 properties: a Token & an Appointment object containing every needed info to make a request.
        //That's why we isolate both of them and put them in two different variables for efficienty.
        $token = $request['token'];
        $appointment = $request['appointment'];
    
        //VALIDATION
        
        // $data = request()->validate([
        //     'student_id' =>'required',
        //     'user_id' => 'required',
        //     'date' => 'required',
        //     'startsAt' =>'required',
        //     'subject' => 'required',
        //     'status' => '',
        //     'canceltoken' => '',
        // ]);

      
        //Since a first token is generated at the VueJS side, we hash it once more in the backend. Hashing technique used -> [sha256].
        $hashedToken = hash('sha256',$token);
        
            //Create an appointment in the DB using Laravel eloquent Models.
            $appointment = Appointment::create(array(
        
                'student_id' => $appointment['student_id'],
                'user_id' => $appointment['user_id'],
                'date' => $appointment['date'],
                'startsAt' => $appointment['startsAt'],
                'subject' => $appointment['subject'],
                'status' => 'pending',
                'cancelToken' => $hashedToken,
                )
            );
        
        //For testing purposes, we return the made object to the axios call in question.
        return response()->json($appointment);
    }

    //Get all appointments with confirmed status
    public function getConfirmed()
    {
        // Join the database of appointments and students => gives all apppointments with 'confirmed' status + the first/last name linked to the appointments
        //So we can get this data in our appointment.vue
        $users = DB::table('appointments')
        ->join('students', 'students.student_id', '=', 'appointments.student_id')
        ->select('appointments.*', 'students.firstName', 'students.lastName')
        ->where('status', 'confirmed')
         ->get();
    
       return response()->json($users);
    }

    //Get all appointments with pending status
    public function getPending()
    {
        // Join the database of appointments and students => gives all apppointments with 'pending' status + the first/last name linked to the appointments
        //So we can get this data in our appointment.vue
        $users = DB::table('appointments')
        ->join('students', 'students.student_id', '=', 'appointments.student_id')
        ->select('appointments.*', 'students.firstName', 'students.lastName')
        ->where('status', 'pending')
         ->get();

       return response()->json($users);
    }
    
    

    
}
