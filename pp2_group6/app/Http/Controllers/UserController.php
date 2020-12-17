<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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

    public function getAll()
    {
        //Fetch all users from DB first.
        $users = User::orderBy('created_at', 'desc')->get();
       
        //Creat empty array template that will be used to fetch only free users(secretary).
        $usersArray = array( 

        );

        //For each user, check if at least one availability starting from today. If yes, push in array.
        foreach($users as $user) {

            //Each user represents full data fiels of that user particularly.

            //Isolate user ID.
            $user_id = $user['user_id'];

            //Check if count('status' = free) > 0
            $matchThese = ['user_id' => $user_id, 'status' => 'free'];
         
            //If availability where 'status' = 'free' count() > 0, push user object to array above.
            if($availabilityCount = Availability::where($matchThese)->where('date', '>', Carbon::now())->count()) {
                if($availabilityCount > 0) {

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
