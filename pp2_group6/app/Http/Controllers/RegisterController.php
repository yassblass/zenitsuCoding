<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {

        $request->validate([
            'firstName' => ['required'],
            'lastName' => ['required'],
            'email'=> ['required', 'email', 'unique:users'],
            'password' =>['required', 'min:6', 'confirmed']
        ]);

        User::create([
            'user_id' => 5,
            'firstName'=> $request->firstName,
            'lastName'=> $request->lastName,
            'email' => $request->email,
            'admin' => false,
            'password'=> Hash::make($request->password)
        ]);
    }
}
