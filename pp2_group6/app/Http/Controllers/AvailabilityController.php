<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Availability;
use Illuminate\Support\Facades\DB;

class AvailabilityController extends Controller
{
    public function insertAvailabilities(Request $request){
        // Put the array of hours in another array variable
        $hours = $request['hours'];
    
        foreach($hours as $hour){ 
        // Make a string wtih de date and time
         $string = $request['date'] . $hour;
         // Convert the string to datetime
          $date = strtotime($string); 
          // Insert the availabilities to the database
        DB::table('availabilities')->insert([
            ['user_id' => 6, 'date' => $request['date'], 'time' => date('Y-m-d H:i:s', $date), 'status' => 'free']
            
        ]);
            }
    }
}



