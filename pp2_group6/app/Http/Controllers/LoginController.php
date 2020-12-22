<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use App\Models\User;

class LoginController extends Controller
{
    //log the user in
    public function login(Request $request){

        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($request->only('email','password'))){
            return response()->json(Auth::user(),200);
            //return redirect()->intended('/secretary/dashboard');
        }else{
            throw ValidationException::withMessages([
                'email'=>['the provided credentials are incorect']
            ]);
        }
    }


    //function that logs the user out.
    public function logout(){

       Auth::logout();

    }
}
