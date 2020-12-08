<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    //
    public function getIndex(){
        return view('appointments');
    }

    
    public function get(Request $request)
    {
        $appointments = Appointment::orderBy('created_at', 'desc')->get();
        return response()->json($appointments);
    }

    public function store(Request $request)
    {
        $appointment = Appointment::create($request->all());
        return response()->json($appointment);

        // $appointment = new Appointment([
        //     'firstName' => $request->input('firstName'),
        //     'lastName' => $request->input('lastName'),
        //     'secretary' => $request->input('secretary'),
        //     'day' => $request->input('day')
        // ]);

        // $appointment->save();

        // return response()->json($appointment);

    }

    public function delete($id)
    {
        $appointment = Appointment::find($id);
        $appointment->delete();


        // Appointment::destroy($id);

        return response()->json("Deleted.");
    }
}
