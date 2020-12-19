<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use Illuminate\Http\Request;


class AvailabilityController extends Controller
{
    public function getAvailabilities(Request $request)
    {


        //Isolate date & secretary ID (user_id) from request.
        $secretaryId = $request['secretaryId'];
        $date = $request['date'];

        //Get all secretary availabilities where status = 'free' and store them.
        $matchThese = ['user_id' => $secretaryId, 'status' => 'free', 'date' => $date];

        //If query matches, return query result.
        if ($availabilities = Availability::where($matchThese)->orderBy('time', 'ASC')->get()) {

            return response($availabilities);
        } else {
            return response(false);
        }




        // return response($request);
    }
}
