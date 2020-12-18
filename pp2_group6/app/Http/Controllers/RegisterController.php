<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'firstName'=> $request->firstName,
            'lastName'=> $request->lastName,
            'email' => $request->email,
            'admin' => $request->admin,
            'forgot_password' => Hash::make(Str::random(50)),
            'password'=> Hash::make($request->forgot_password)
        ]);
    }
}
