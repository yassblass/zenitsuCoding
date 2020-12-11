<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    
    public function setAvailibility(){
        
        $appointment = Appointment::create(array(
        
            'user_id' => 3,
            'date' => 3,
            'time' => '2020-12-25',
            'status' => '2020-12-25 18:02:54'
             )
            );
            // $appointment->save();
    
            return response()->json($request);
    }
}
