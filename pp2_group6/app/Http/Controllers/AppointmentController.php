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
        //  $users = DB::table('appointments')
        //      ->join('students', 'student_id', '=', 'students.student_id')
        //      ->select('appointments.*', 'students.firstName', 'students.lastName')
        //      ->where('status', 'confirmed')
        //      ->get();

        $users = DB::table('appointments')
        ->join('students', 'students.student_id', '=', 'appointments.student_id')
        ->select('appointments.*', 'students.firstName', 'students.lastName')
        ->where('status', 'confirmed')
         ->get();

        //$ids = Appointment::select('user_id')-> where('status', 'confirmed')->get();
        
        


      // $appointment = Appointment::where('status', 'confirmed')->

    
       return response()->json($users);
    }


    public function getIndex(){
        return view('appointments');
    }



    
    public function get(Request $request)
    {
        $appointments = Appointment::orderBy('created_at', 'asc')->get();
        return response()->json($appointments);
    }

    public function store(Request $request)
    {
        //$appointment = Appointment::create($request->all());
        //return response()->json($appointment);


        

    
        // $appointment = User::create(array(
        
        //     'firstName' => 'Test',
        //     'lastName' => 'test',
        //     'email' => 'yaibzfyi@greoiungh.com',
        //     'password' => 'password',
        //      )
        //     );

        $appointment = Appointment::create(array(
        
        'student_id' => 3,
        'user_id' => 3,
        'date' => '2020-12-25',
        'startsAt' => '2020-12-25 18:02:54',
        'subject' => 'yassine la grosse folle',
        'status' => 'accepted',
        'cancelToken' => 'eriahuyfzrerergzèrearaeriahuyfzrerergzèreara'
         )
        );
    
    
        
    

        // $appointment->save();

        return response()->json($request);

    }


    public function delete($id)
    {
        

        Appointment::where('appointmentId', $id)->delete();

        //Appointment::find(2)->delete();
        //$appointments = Appointment::where('appointmentId', $id)->get();

        // if($appointment->delete()){
        //     return view('appointments');
        // }
        // else{
        //     return response()->json(['error' => 'Destroy mission has failed'],425);
        // }
    
        //$appointments->delete();
        //$appointment->subject = "lolzzz";
        //$appointment->save();
        // Appointment::destroy($id);

        return response()->json($id);
    }

    public function deleteApp($id)
    {
        

        User::find(3)->delete();



        //Appointment::find(2)->delete();
        //$appointment->subject = "lolzzz";
        //$appointment->save();
        // Appointment::destroy($id);
        // $appointment = Appointment::find($id);

       if($appointment->delete()){
           return view('appointments');
       }
       else{
           return response()->json(['error' => 'Destroy mission has failed'],425);
       }
       return response()->json($id);
    }

    public function encrypt($token) {

        $hashedToken = hash('sha256',$token);

        $user = User::select('name')->where('id', 9)->get()->first();

        $app = Appointment::create(
            array(
                'firstName' =>'Adil',
                'lastName' => 'Travlo',
                'secretary' => $user['name'],
                'day' =>'monday',
                'cancelToken' => $hashedToken
            )


        );

        

        return response()->json($app);
    }

    public function showCancelPage ($token){


        //8aa32d535944427a88ec2a75fe957aa387509c009cceda69b9a2d0f8450ea46f
        

        if (Appointment::where('cancelToken', '=', $token)->exists() > 0) {

            $check = "Appointment exists!";

            $appointment = array(
                'id' => '',
                'firstName' => '',
                'lastName' => '',
                'secretary' => '',
                'cancelToken' => '',
        );

            $appointment = json_encode($appointment);


            $appointment = Appointment::where('cancelToken', $token)->get();


            $id = $appointment[0]['id'];
            $name = $appointment[0]['firstName'] . ' ' . $appointment[0]['lastName'];
            $secretary = $appointment[0]['secretary'];


            return view("cancelPage", compact("id","name","secretary","check","token"));
        }
        else{

            $check = "Appointment doesn't exist!";

            return view("cancelPage", compact("check"));
        };

    
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $appointment = Appointment::find($id);

       if($appointment->delete()){
           return view('appointment');
       }
       else{
           return response()->json(['error' => 'Destroy mission has failed'],425);
       }

        
    }

    public function getMail(){
      
    }
}
