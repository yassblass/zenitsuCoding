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
    //Function to get all the appointments that are confirmed
    public function getListConfirmed()
    {
        //Take the date of today.
        $today = date("Y-m-d");
        //Take the user that is loged in.
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
    public function getListPending()
    {
        //Take the user that is loged in.
        $user = Auth::user();
        //Take the date of today.
        $today = date("Y-m-d");

        // Join the database of appointments and students => gives all apppointments with 'pending' status + the first/last name linked to the appointments
        $users = DB::table('appointments')
        ->join('students', 'students.student_id', '=', 'appointments.student_id')
        ->select('appointments.*', 'students.firstName', 'students.lastName')
        ->where('status', 'pending')
        ->where('appointments.date', '>=', $today)
        ->where('user_id', $user->user_id)
        ->get();

       return response()->json($users);
    }
    
    

    
}
