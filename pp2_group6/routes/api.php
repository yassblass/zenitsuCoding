<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//return logged user 
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// return true if user is logged in
Route::middleware('auth:sanctum')->get('/authenticated', function () {
    return true;
});

//Register a new user
Route::post('register', [App\Http\Controllers\RegisterController::class, 'register']);
//route to try to log in a user
Route::post('login', [App\Http\Controllers\LoginController::class, 'login']);
//route to logout the logged in user 
Route::post('logout', [App\Http\Controllers\LoginController::class, 'logout']);

Route::get('/appointmentLists', [App\Http\Controllers\AppointmentController::class,'getConfirmed']);
Route::post('/cancelSubmit', [App\Http\Controllers\MailController::class,'cancelSubmit']);

Route::get('/appointmentList', \App\Http\Controllers\AppointmentController::class .'@getPending');

