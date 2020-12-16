<?php

namespace App\Http\Controllers;
Use \Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class AppointmentController extends Controller
{   
    //Get all appointments with confirmed status
    public function getConfirmed()
    {
        $today = date("Y-m-d");

        $user = Auth::user();
        
        // Join the database of appointments and students => gives all apppointments with 'confirmed' status + the first/last name linked to the appointments
        //So we can get this data in our appointment.vue
        $users = DB::table('appointments')
        ->join('students', 'students.student_id', '=', 'appointments.student_id')
        ->select('appointments.*', 'students.firstName', 'students.lastName')
        ->where('status', 'confirmed')
        ->where('appointments.date', '>=', $today)
        ->where('user_id', '=', $user->user_id)
        ->get();

      
    
       return response()->json($users);
    }

    //Get all appointments with pending status
    public function getPending()
    {
        $user = Auth::user();

        // Join the database of appointments and students => gives all apppointments with 'pending' status + the first/last name linked to the appointments
        //So we can get this data in our appointment.vue
        $users = DB::table('appointments')
        ->join('students', 'students.student_id', '=', 'appointments.student_id')
        ->select('appointments.*', 'students.firstName', 'students.lastName')
        ->where('status', 'pending')
        ->where('user_id', $user->user_id)
        ->get();

       return response()->json($users);
    }
    
    

    
}
