<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


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

    
    public function getAllUsers(){

        $users = User::All();

        return $users;
    }

    public function get(Request $request)
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return response()->json($users);
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
