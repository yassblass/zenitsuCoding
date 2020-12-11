<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Http\Controllers\Controller;
use App\shift_master_models;

class AppointmentController extends Controller
{
    public function getAppointmentsInPending()
    {
      $appointment = Appointment::where('status', '=' ,'pending')->get();

       return response()->json($appointment);
    }

    public function updateAccepted($appointmentId){
              
    if (Appointment::find($appointmentId))
        {
            $appointment=Appointment::find($appointmentId)->update(['status' => 'confirmed']);

            return response()->json($appointment);
        }
        else
        {
            $errorMessage = "Appointment Not Found!";
            return response()->json($errorMessage);
        }
    }

    public function updateRefused($appointmentId){
        if (Appointment::find($appointmentId))
        {
            $appointment=Appointment::find($appointmentId)->update(['status' => 'refused']);

            return response()->json($appointment);
        }
        else
        {
            $errorMessage = "Appointment Not Found!";
            return response()->json($errorMessage);
        }
              

    }

}
