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


}
