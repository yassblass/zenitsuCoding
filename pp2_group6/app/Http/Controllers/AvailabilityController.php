<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Availability;
use Illuminate\Support\Facades\DB;

class AvailabilityController extends Controller
{
    public function insertAvailabilities(Request $request){
        $hours = $request['hours'];
        // $string;
        foreach($hours as $hour){ 
         $string = $request['date'] . $hour;
          $date = strtotime($string); 
        DB::table('availabilities')->insert([
            ['user_id' => 1, 'date' => $request['date'], 'time' => date('Y-m-d H:i:s', $date), 'status' => 'available']
            
        ]);
// foreach($hours as $hour){
//     $availability = Availability::create(array(                              
//         'user_id' => 2,                 
//         'date' => $request['date'],                 
//         'time' => $hour,                 
//         'status' => 'free',                 
//                 ));
            }
    }
}



