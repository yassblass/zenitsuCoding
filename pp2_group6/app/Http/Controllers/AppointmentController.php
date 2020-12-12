<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Appointment;


class AppointmentController extends Controller
{

    //Return to appointments page.
    public function getIndex(){
        return view('appointments');
    }

    //Get all appointments from DB.
    public function get(Request $request)
    {
        $appointments = Appointment::orderBy('created_at', 'asc')->get();
        return response()->json($appointments);
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
    public function makeRequest(Request $request) {


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
    public function store(Request $request)
    {
        //$appointment = Appointment::create($request->all());
        //return response()->json($appointment);


        

    
        // $appointment = User::create(array(
        
        //     'firstName' => 'Test',
        //     'lastName' => 'test',
        //     'email' => 'yaibzfyi@greoiungh.com',
        //     'password' => 'password',
        //      )
        //     );

        $appointment = Appointment::create(array(
        
        'student_id' => 2,
        'user_id' => 2,
        'date' => '2020-12-10',
        'startsAt' => '2020-12-10 16:02:54',
        'subject' => 'Subject',
        'status' => 'pending',
        'cancelToken' => 'eriahuyfzrerergzèreara'
         )
        );
    
    
        
    
        // $appointment->save();

        return response()->json($request);

    }

}
