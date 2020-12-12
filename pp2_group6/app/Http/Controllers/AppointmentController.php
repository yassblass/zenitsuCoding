<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // Join the database of appointments and students to get the firstname and lastname of the student
        //So we can get this data in our appointment.vue
        $users = DB::table('appointments')
        ->join('students', 'students.student_id', '=', 'appointments.student_id')
        ->select('appointments.*', 'students.firstName', 'students.lastName')
        ->where('status', 'confirmed')
         ->get();
    
       return response()->json($users);
    }



    public function delete($id)
    {
        Appointment::where('appointmentId', $id)->delete();
        return response()->json($id);
    }

    public function getAppointmentsInPending()
    {
    // Join the database of appointments and students to get the firstname and lastname of the student
        //So we can get this data in our appointment.vue
        $users = DB::table('appointments')
        ->join('students', 'students.student_id', '=', 'appointments.student_id')
        ->select('appointments.*', 'students.firstName', 'students.lastName')
        ->where('status', 'pending')
         ->get();

       return response()->json($users);
    }
    

    public function updateAccepted($appointmentId){
        // Function secretary to accept the appointment
        // extra check to be sure that he founds the appointment
    if (Appointment::find($appointmentId))
        {
            // It will change the status from pending to confirmed when you click on the 'accept' button
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
        // Function secretary to refuse the appointment
        // extra check to be sure that he founds the appointment
        if (Appointment::find($appointmentId))
        {
            // It will change the status from pending to refused when you click on the 'accept' button

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
