<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use App\Models\Availability;
use Carbon\Carbon;

class UserController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    // find user and change his password
    public function changePassword(Request $request){
       
        $password = $request['password'];
        $forgot_password = $request['forgot_password'];
        $id = $request['id'];

        if (User::find($id))
        {
            $newPassToken = Str::random(50);
            User::find($id)->update(['forgot_password' => $newPassToken]);
            User::find($id)->update(['password' => Hash::make($password)]);
        }
        else
        {
            $errorMessage = "User Not Found!";
            return response()->json($errorMessage);
        }
    }

    //upload new avatar
    public function uploadAvatar(Request $request){

        $id = Auth::user()->user_id;
        $firstName = Auth::user()->firstName;

        $this->validate($request,[
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,jfif',
        ]);

        $image= request()->file('image');

        $imageName = $image->getClientOriginalName();

        $imageName = "{$id}_".$firstName.'_'.$imageName;

        $image->move(public_path('uploads/avatars'), $imageName);

        User::find($id)->update(['avatar' => $imageName]);

    }

    //get all users
    public function getAllUsers(){

        $users = User::All();
        return $users;
    }

   //Fetch all users with at least one availability on the day chosen by the student.
    public function getAll(Request $request)
    {
        //Fetch all users from DB first.
        $users = User::orderBy('created_at', 'desc')->get();
        $chosenDate = $request['date'];
        //Creat empty array template that will be used to fetch only free users(secretary).
        $usersArray = array();

        //For each user, check if at least one availability for the chosen day. If yes, push in array.
        foreach ($users as $user) {

            //Each user object represents full data fields of that user particularly.
            //Isolate user ID.
            $user_id = $user['user_id'];

            //Check if count('status' = free) > 0
            $matchThese = ['user_id' => $user_id, 'status' => 'free'];

            //If availability where 'status' = 'free' count() > 0, push user object to array above.
            if ($availabilityCount = Availability::where($matchThese)->where('date', $chosenDate)->count()) {
                if ($availabilityCount > 0) {

                    //push this user's name into array.
                    $freeUser = User::find($user_id);
                    array_push($usersArray, $freeUser);
                }
            }
        }

        //Return array of free users which will be displayed on the front-end.
        return response($usersArray);
    }


    //Get user name.
    public function getName($userId)
    {
        $userName = User::select('firstName', 'lastName')->where('user_id', $userId)->get();
        return response()->json($userName[0]);
    }
}
