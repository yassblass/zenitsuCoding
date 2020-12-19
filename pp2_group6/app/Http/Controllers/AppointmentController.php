<?php

namespace App\Http\Controllers;
Use \Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Needed Models

use App\Models\Appointment;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use App\Models\Availability;


//Mail models
use App\Mail\requestMail;
use App\Mail\cancelMailToSecretary;
use App\Mail\requestToSecretary;

use Mail;

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
    

    //Return to appointments page.
    public function getIndex()
    {
        return view('student/appointments');
    }

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

    //Get all appointments from DB.
    public function get(Request $request)
    {
        //Fetch all apointments from DB. Return true/false.
        if ($appointments = Appointment::orderBy('created_at', 'asc')->get()) {

            return response($appointments);
        } else {
            return response(false);
        }
    }

    //Refuse an appointment
    public function refuseAppointment($appointmentId)
    {
        if (Appointment::find($appointmentId)) {
            $appointment = Appointment::find($appointmentId)->update(['status' => 'refused']);

            return response()->json($appointment);
        } else {
            $errorMessage = "Appointment Not Found!";
            return response()->json($errorMessage);
        }
    }

    //Get all appointments in 'pending' state.
    public function getPendingAppointments()
    {
        $appointment = Appointment::where('status', '=', 'pending')->get();

        return response()->json($appointment);
    }

     //Delete an appointment
     public function delete($appointmentId)
     {
         //Get the date of the appointment 
         $dateAppointment = Appointment::select('date')->where('appointmentId', '=', $appointmentId)->get();
         $dateApp = $dateAppointment[0]->date;
        

 
         //Get data of the availability
         $getAvUserId = Availability::select('user_id')->where('date', '=', $dateApp)->get();
         $userId = $getAvUserId[0]->user_id;
         $getAvDate = Availability::select('date')->where('date', '=', $dateApp)->get();
         $date = $getAvDate[0]->date;
         $getAvTime= Availability::select('time')->where('date', '=', $dateApp)->get();
         $time = $getAvTime[0]->time;
         
         //For where statement
         $matchThese = ['user_id' => $userId, 'date' => $date, 'time' => $time];
 
         //Get status from availabily
         $getAvStatus = Availability::select('status')->where($matchThese)->get(); 
         $status = $getAvStatus[0]->status;

         $currentDate = date("Y-m-d");
         
        if($dateApp > $currentDate)
        {
            //Get the availability based on the appointmentId and update the status to free
            Availability::select('avId')->where($matchThese)->update(['status' => 'free']);
            //Delete appointment from DB based on Appointment ID. 
            Appointment::where('appointmentId', $appointmentId)->delete();


            return response()->json("Date is not passed -> availability set to free and deleted appointment!");
        } else {
            //Get the availability based on the appointmentId and update the status to free
            Availability::select('avId')->where($matchThese)->delete();
            //Delete appointment from DB based on Appointment ID. When the date is passed already 
            Appointment::where('appointmentId', $appointmentId)->delete();

            return response("Date is passed -> Delete appointment and availability!");
        }
    }

    //Cancel an appointment based on appointment ID.
    public function cancelAppointment($appointmentId)
    {
        //Check if appointment that needs to be deleted was 'confirmed' or 'pending'. If 'confirmed', flagCounter + 1.
        if($appointment = Appointment::where('appointmentId',$appointmentId)->get()) 
        {
            //------------------------------------------------------------------------------------------------------
                //Set avaialbility back to free if appointment gets canceled and appointment date > date now.
                //If date is passed, availability should theoretically be deleted by implemented schedulers when Web App bil be hosted on a server.
                //Store current date using Carbon library.
                $currentDate = Carbon::now();

                if($appointment[0]['date'] > $currentDate)
                {
                    //This query needs to be matched in order to isolate the availability row in DB.
                    $matchThese = ['user_id' => $appointment[0]['user_id'], 'date' => $appointment[0]['date'], 'time' => $appointment[0]['startsAt']];
                    //Get the availability based on the appointmentId and update the status to free
                    Availability::select('avId')->where($matchThese)->update(['status' => 'free']);
                }       
                else 
                {
                //Delete availability from DB based on Appointment ID, When the date is passed.
                Availability::where($matchThese)->update(['status' => 'free'])->delete();
                }


            //check if appointment is 'confirmed'.
            if ($appointment[0]['status'] === 'confirmed') {

                //Isolate student ID
                $student_id = $appointment[0]['student_id'];

                //Flagcounter + 1;
                Student::where('student_id', $student_id)->update(['flagCounter' => DB::raw('flagCounter + 1')]);

                //-----------------------------------------------------
                //Check if flagCounter >= 5. If yes, set 'isFlagged' to 1.
                $student = Student::where('student_id', $student_id)->get();

                if ($student[0]['flagCounter'] >= 5) {

                    //Set 'isFlagged' field to 1.
                    Student::where('student_id', $student_id)->update(['isFlagged' => 1]);
                }

                


                //Locally store appointment information in order to be able to send them as an email after it gets deleted.
                $date= $appointment[0]['date'];
                $startsAt = $appointment[0]['startsAt'];;

                //Isolate student Name & secretary Name
                $studentName = Student::select('firstName', 'lastName')->where('student_id', $student_id)->get();
                $studentName = $studentName[0]['firstName'] . " " . $studentName[0]['lastName'];

                $secretaryName = User::select('firstName', 'lastName')->where('user_id', $appointment[0]['user_id'])->get();
                $secretaryName = $secretaryName[0]['firstName'] . " " . $secretaryName[0]['lastName'];
                
                //Isolate Secretary email.
                $secretaryId = Appointment::select('user_id')->where('appointmentId',$appointmentId)->get();
                $secretaryEmail = User::select('email')->where('user_id', $secretaryId[0]['user_id'])->get();

                //Perform delete query, trigger actions accordingly.
                if(Appointment::where('appointmentId',$appointmentId)->delete()) 
                {

                //Notify secretary about the canceling by email.
                $cancelByStudent = array(
                    'date' => $date,
                    'startsAt' => $startsAt,
                    'secretaryName' => $secretaryName,
                    'studentName' => $studentName,
                );

                //Send cancel mail to secretary.
                Mail::to($secretaryEmail[0]['email'])->send(new cancelMailToSecretary($cancelByStudent));
               
                

                //If TRUE, returns 1 to AXIOS CALL in Vue component called 'cancelPage'.
                return response(true);
    
                }else 
                {
                //If FALSE, returns 0 to AXIOS CALL in Vue component called 'cancelPage'.
                return response(false);
                }   
            }

            //If appointment status is not 'confirmed' but 'pending'.
            else if($appointment[0]['status'] === 'pending') {
               
                //If appointment status is 'pending' simply delete the appointment without adding +1 to the flagCounter.
                Appointment::where('appointmentId',$appointmentId)->delete();

                //Return true if delete = success.
                return response(true);
            }
        } else {
            //If appointment is not found.
            return response(false);
        }
    }
        
        
    //Simple test function to return appointments.blade.php as a view.
    public function returnView()
    {
        return view('student/appointments');
    }

    

    //Show cancel page based on token.
    public function showCancelPage($token)
    {
        //8aa32d535944427a88ec2a75fe957aa387509c009cceda69b9a2d0f8450ea46f

        //Check if appointment exists with token.
        if (Appointment::where('cancelToken', '=', $token)->exists()) {

            //Simple check message for testing purposes.
            $check = "Appointment Details";

            //Make empty appointment array template, will be used below.
            $appointment = array(
                'secretaryName' => '',
                'studentName' => '',
                'date' => '',
                'startsAt' => '',
                'subject' => '',
                'status' => '',
                'appointmentId' => '',
            );
            //Perform querybuilder, get appointment that is linked to given token.
            $getAppointment = Appointment::select('appointmentId', 'student_id', 'user_id', 'date', 'startsAt', 'subject', 'status')->where('cancelToken', $token)->get();

            //Isolate secretary name
            $secretaryName = User::select('firstName', 'lastName')->where('user_id', $getAppointment[0]['user_id'])->get();
            //Isolate student name
            $studentName = Student::select('firstName', 'lastName')->where('student_id', $getAppointment[0]['student_id'])->get();

            //Fill in appointment object with input data.
            $appointment[0] = $secretaryName[0]['firstName'] . " " . $secretaryName[0]['lastName'];
            $appointment[1] = $studentName[0]['firstName'] . " " . $studentName[0]['lastName'];
            $appointment[2] = $getAppointment[0]['date'];
            $appointment[3] = $getAppointment[0]['startsAt'];
            $appointment[4] = $getAppointment[0]['subject'];
            $appointment[5] = $getAppointment[0]['status'];
            $appointment[6] = $getAppointment[0]['appointmentId'];


            //Passing appointment array to Vuejs gave errors, until error gets fixed, we send every param individually.
            $appointmentId = $appointment[6];
            $secretaryName = $appointment[0];
            $studentName = $appointment[1];
            $date = $appointment[2];
            $startsAt = $appointment[3];
            $subject = $appointment[4];
            $status = $appointment[5];

            
            
            //Return view called 'cancelPage' with appointment data.
            return view("student.cancelPage", compact('check', 'appointmentId', 'secretaryName', 'studentName', 'date', 'startsAt', 'subject', 'status'));
        } else {

            //return view with only check message.
            return view("student.wrongToken");
        }
    }


    //Checks if the given email exists in EhB DB
    public function checkEmail(Request $request)
    {
        //Data validation before inserting appointment in DB
        $this->validate($request, [
            'firstName' => 'required',
            'lastName' => 'required',
        ]);

        $domain = '@student.ehb.be';
        $firstName = $request['firstName'];
        $lastName = $request['lastName'];

        //Concat firstName, lastName and domain to give email of format : firstName.lastName@student.ehb.be
        $email = $firstName . '.' . $lastName . $domain;

        //Check if given $email exist in DB
        $checkEmail = Student::where('email', '=', $email)->exists();

        // If email exists, create an appointment request.
        if ($checkEmail) {
            //Get student_id based on given email
            $getStudentId = Student::select('student_id')->where('email', '=', $email)->get();

            //Get 'hasRight' field from student table based on user_id
            $getHasRight = Student::select('hasRight')->where('student_id', '=', $getStudentId[0]->student_id)->get();

            //Get 'flagged" field from student table based on user_id
            $getFlagged = Student::select('isFlagged')->where('student_id', '=', $getStudentId[0]->student_id)->get();

            if ($getHasRight[0]->hasRight === 1) {
                if ($getFlagged[0]->isFlagged === 0) {
                    //All check done, return student_id based on email
                    return response(1);
                } else {
                    //When the student is flagged
                    return response(2);
                }
            } else {
                //When the student has no rights
                return response(3);
            }
        } else {
            //When the email does not exist in the organization
            return response(0);
        }
    }

    //Make an appointment request
    public function makeRequest(Request $request)
    {
        // request: {
        //     student_id: "",
        //     firstName: "",
        //     lastName: "",
        //     user_id: "",
        //     date: "",
        //     startsAt: "",
        //     subject: "",
        //   },

        //Declare needed varibales.
        //IsolateToken & Appointment object from request.
        $token = $request['token'];
        $appointment = $request['request'];
        $domain = '@student.ehb.be';
        $firstName = $appointment['firstName'];
        $lastName = $appointment['lastName'];

        //Concat firstName, lastName and domain to give email of format : firstName.lastName@student.ehb.be
        $email = $firstName . '.' . $lastName . $domain;

        //Check if given $email exist in DB
        $checkEmail = Student::where('email', '=', $email)->exists();

        //Hash first version of given token 
        $hashedToken = hash('sha256', $token);

        // If email exists, create an appointment request.
        if ($checkEmail) {
            $getStudentId = Student::select('student_id')->where('email', '=', $email)->get();
            $getHasRight = Student::select('hasRight')->where('student_id', '=', $getStudentId[0]->student_id)->get();

            //Get 'flagged" field from student table based on user_id
            $getFlagged = Student::select('isFlagged')->where('student_id', '=', $getStudentId[0]->student_id)->get();

            //Since a first token is generated at the VueJS side, we hash it once more in the backend. Hashing technique used -> [sha256].
            $hashedToken = hash('sha256', $token);
            //Get student_id based on given email


            if ($getHasRight[0]->hasRight === 1) {
                if ($getFlagged[0]->isFlagged === 0) {

                    $appointment = Appointment::create(array(
                        'student_id' => $getStudentId[0]->student_id,
                        'user_id' => $appointment['user_id'],
                        'date' => $appointment['date'],
                        'startsAt' => $appointment['startsAt'],
                        'subject' => $appointment['subject'],
                        'status' => 'pending',
                        'cancelToken' => $hashedToken,
                    ));

                    $matchThese = ['user_id' => $appointment['user_id'], 'date' => $appointment['date'], 'time' => $appointment['startsAt']];
                    $takenAvailabilityId = Availability::where($matchThese)->update(['status' => 'taken']);
                    //Availability::find($takenAvailabilityId)->update(['status' => 'taken']);

                    //Appointment creation succesful. Send request confirmation as email.

                    $secreterayNameQuery = User::select('firstName', 'lastName')->where('user_id', $appointment['user_id'])->get();
                    $secretayFirstName = $secreterayNameQuery[0]['firstName'];
                    $secretaylastName = $secreterayNameQuery[0]['lastName'];
                    $secretaryName = $secretayFirstName . ' ' . $secretaylastName;
                    $cancelLink = "http://127.0.0.1:8000/appointment/token/" . $hashedToken;

                    //Create Mail template with needed data.
                    $requestForMail = array(
                        'firstName' => $firstName,
                        'lastName' => $lastName,
                        'date' => $appointment['date'],
                        'startsAt' => $appointment['startsAt'],
                        'subject' => $appointment['subject'],
                        'secretaryName' => $secretaryName,
                        'cancelLink' => $cancelLink,
                    );

                    //Mail to student with request information.
                    Mail::to($email)->send(new requestMail($requestForMail));

                    //Isolate secretary email 
                    $secretaryEmail = User::select('email')->where('user_id', $appointment['user_id'])->get();

                    //Store link to dahsboard into a variable (Localhost for now)
                    $dashboardLink = "http://127.0.0.1:8000/";

                    //Create Mail template with needed data.
                    $requestToSecretary = array(
                        'firstName' => $firstName,
                        'lastName' => $lastName,
                        'date' => $appointment['date'],
                        'startsAt' => $appointment['startsAt'],
                        'subject' => $appointment['subject'],
                        'secretaryName' => $secretaryName,
                        'dashboardLink' => $dashboardLink,
                    );

                    //Mail To secretary with request information.
                    Mail::to($secretaryEmail[0]['email'])->send(new requestToSecretary($requestToSecretary));


                    return response(1);
                } else {
                    //When the student is flagged
                    return response(2);
                }
            } else {
                //When the student has no rights
                return response(3);
            }
        } else {
            //When the email does not exist in the organization
            return response(0);
        }
    }
}
