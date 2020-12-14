<?php

namespace App\Http\Controllers;
use App\Models\Availability;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function getAvailabilities ($secretaryId) {

        //Get all secretary availabilities where status = 'free' and store them.
        

        $matchThese = ['user_id' => $secretaryId, 'status' => 'free'];

        if($availabilities = Availability::where($matchThese)->get()){

            return response($availabilities);
        }
        else{
            return response(false);
        }


        //return response($secretaryId);
    }
}
