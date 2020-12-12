<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Appointment;


class AppointmentController extends Controller
{



    public function getIndex(){
        return view('appointments');
    }

    
    public function get(Request $request)
    {
        $appointments = Appointment::orderBy('created_at', 'asc')->get();
        return response()->json($appointments);
    }


    

    public function store(Request $request)
    {
        $domain = '@student.ehb.be';
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $email = $firstName . '.' . $lastName . $domain;


        //Check if given $email exist in DB
        $checkEmail = Student::where('email', '=', $email)->exists();
        //Gives object with student_id based on given EMAIL () from DB
        $getStudentId = Student::select('student_id')->where('email', '=', $email)->get();

        //Gives object with user_id based on given USER

        if($checkEmail){
            $appointment = Appointment::create(array(
                'student_id' => $getStudentId[0]->student_id,
                'user_id' => $request->input('user_id'),
                'date' => $request->input('date'),
                'startsAt' => $request->input('startsAt'),
                'subject' => $request->input('subject'),
                'status' => 'pending',
                'cancelToken' => 'lkcjwsldqsdfssdfgsdfgqdqsdfqsdkjf'
            ));
        } 

        return response()->json($appointment);
    }

    public function delete($id)
    {

        Appointment::where('appointmentId', $id)->delete();

        return response()->json($id);
    }

    // public function delete($id)
    // {
    //     User::find(3)->delete();
    //     //Appointment::find(2)->delete();
    //     //$appointment->subject = "lolzzz";
    //     //$appointment->save();
    //     // Appointment::destroy($id);
    //     // $appointment = Appointment::find($id);
    //    if($appointment->delete()){
    //        return view('appointments');
    //    }
    //    else{
    //        return response()->json(['error' => 'Destroy mission has failed'],425);
    //    }
    //     return response()->json($id);
    // }


    public function encrypt($token) {

        $hashedToken = hash('sha256',$token);

        $user = User::select('name')->where('id', 9)->get()->first();

        $app = Appointment::create(
            array(
                'firstName' =>'Adil',
                'lastName' => 'Travlo',
                'secretary' => $user['name'],
                'day' =>'monday',
                'cancelToken' => $hashedToken
            )


        );

        

        return response()->json($app);
    }

    public function showCancelPage ($token){


        //8aa32d535944427a88ec2a75fe957aa387509c009cceda69b9a2d0f8450ea46f
        

        if (Appointment::where('cancelToken', '=', $token)->exists() > 0) {

            $check = "Appointment exists!";

            $appointment = array(
                'id' => '',
                'firstName' => '',
                'lastName' => '',
                'secretary' => '',
                'cancelToken' => '',
        );

            $appointment = json_encode($appointment);


            $appointment = Appointment::where('cancelToken', $token)->get();


            $id = $appointment[0]['id'];
            $name = $appointment[0]['firstName'] . ' ' . $appointment[0]['lastName'];
            $secretary = $appointment[0]['secretary'];


            return view("cancelPage", compact("id","name","secretary","check","token"));
        }
        else{

            $check = "Appointment doesn't exist!";

            return view("cancelPage", compact("check"));
        }

    
        
    }
}
