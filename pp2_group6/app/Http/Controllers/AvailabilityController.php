<?php

namespace App\Http\Controllers;
use App\Models\Availability;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function getAvailabilities () {

        //Get all secretary availabilities where status = 'free' and store them.
        
        if($availabilities = Availability::where('status', 'free')){

            return respone(true);
        }
        else{
            return respone(false);
        }
        
    }
}
