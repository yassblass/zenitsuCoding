<?php

namespace App\Http\Controllers;
use App\Models\Availability;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function getAvailabilities ($secretaryId) {

        //Get all secretary availabilities where status = 'free' and store them.
        

        $matchThese = ['user_id' => $secretaryId, 'status' => 'free'];

    
        $availabilitiesObject = array(
            'avId' => '',
            'user_id' => '',
            'date' => '',
            'time' => '',
            'status' => '',
    );

        

        if($availabilities = Availability::where($matchThese)->get()){

            foreach ($availabilities as $availability) {
        
        $availabilitiesObject[0]=$availability['avId'];
        $availabilitiesObject[1]=$availability['user_id'];
        $availabilitiesObject[2]=$availability['date'];
        $availabilitiesObject[3]=$availability['time'];
        $availabilitiesObject[4]=$availability['status'];

              }
       


            return response($availabilitiesObject);
        }
        else{
            return response(false);
        }

        


        //return response($secretaryId);
    }
}
