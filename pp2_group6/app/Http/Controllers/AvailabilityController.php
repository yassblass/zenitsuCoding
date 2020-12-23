<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AvailabilityController extends Controller
{

    //Sets a secretary free from 09AM -12PM
    public function setMorningFree (Request $request) {
        $startTime = new Carbon('09:00:00');
        $date=$request['date'];
        $user = Auth::user();

        for ($x = 0; $x <=5; $x++) {

            $matchThese = ['user_id' => $user->user_id, 'time' => $startTime];
            if(Availability::where($matchThese)->count() > 0){
                Availability::find($user->user_id)->delete();
            };

            Availability::create(array(
                'user_id' => $user->user_id,
                'date' => $date,
                'time' =>$startTime,
            ));

            $startTime = $startTime->addMinutes(30);
          }

        return response(1);
    }

    public function setAfternoonFree (Request $request) {
        $startTime = new Carbon('13:30:00');
        $date=$request['date'];
        $user = Auth::user();

        for ($x = 0; $x <=4; $x++) {

            $matchThese = ['user_id' => $user->user_id, 'time' => $startTime];
            if(Availability::where($matchThese)->count() > 0){
                Availability::find($user->user_id)->delete();
            };

            Availability::create(array(
                'user_id' => $user->user_id,
                'date' => $date,
                'time' =>$startTime,
            ));

            $startTime = $startTime->addMinutes(30);
          }
          return response(1);   
    }


    public function insertAvailabilities(Request $request){
        // Put the array of hours in another array variable
        $time = $request['time'];
        $date = $request['date'];
        $user = Auth::user();


        $matchThese = ['date' => $date, 'time' => $time];

        //Check if availability doesn't exist already.
        if(Availability::where($matchThese)->count() > 0){
            //Availability already exists
            return response (0);
        }
        else {
            //Availability can be added
            Availability::create(array(
                'user_id' => $user->user_id,
                'date' => $date,
                'time' =>$time
            ));

            return response(1);

        }
    
        // foreach($hours as $hour){ 
        //     // Make a string wtih de date and time
        //     $string = $request['date'] . $hour;
        //     // Convert the string to datetime
        //     $date = strtotime($string); 
        //     // Insert the availabilities to the database
        //     DB::table('availabilities')->insert([
        //         ['user_id' => $user->user_id, 
        //         'date' => $request['date'], 
        //         'time' => date('Y-m-d H:i:s', $date), 
        //         'status' => 'free']
        //     ]);
        // }
            

        //Check
    }

    public function getAllAvailibility()
    {
        //the day of today
        $today = date("Y-m-d");
        //take the user that is connected
        $user = Auth::user();
        
        $availibilities = DB::table('availabilities')
        ->where('status', 'free')
        ->where('date', '>=', $today)
        ->where('user_id', '=', $user->user_id)
        ->orderBy('date', 'ASC')
        ->get();

       return response()->json($availibilities);
    }

    public function deleteAvailability($avId)
   {
       
    //Search in Appointment model where appointmentid = appointmentid 
    if (Availability::find($avId) )
    {
        //If you find the ID, delete the appointment
        $Availability=Availability::where('avId', '=' , $avId)->delete();

        return response()->json($Availability);
    }
    else
    {
        //if the appointment is not found, delete the appointment
        $errorMessage = "Appointment Not Found!";
        return response()->json($errorMessage);
    }
   }

   //Get secretary availabilities.
    public function getAvailabilities(Request $request)
    {
        //Isolate date & secretary ID (user_id) from request.
        $secretaryId = $request['secretaryId'];
        $date = $request['date'];

        //Get all secretary availabilities where status = 'free' and store them.
        $matchThese = ['user_id' => $secretaryId, 'status' => 'free', 'date' => $date];

        //If query matches, return query result.
        if ($availabilities = Availability::where($matchThese)->orderBy('time', 'ASC')->get()) {

            //If Availabilities found, return them.
            return response($availabilities);
        } else {
            //If no availability found.
            return response(false);
        }
    }
}