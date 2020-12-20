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
//get all users
Route::get('/allUsers', [App\Http\Controllers\UserController::class,'getAllUsers']);
//route to send mail to change the password
Route::post('/forgot', [App\Http\Controllers\MailController::class,'forgot']);
//route to change the password
Route::post('/changePassword', [App\Http\Controllers\UserController::class,'changePassword']);
//route to change the user avatar
Route::post('/uploadAvatar', [App\Http\Controllers\UserController::class,'uploadAvatar']);
//route to get all appointments that are confirmed
Route::get('/appointmentListConfirmed', [App\Http\Controllers\AppointmentController::class,'getListConfirmed']);
//route to cancel an appointment that has been confirmed
Route::post('/cancelAppointment/{id}', [App\Http\Controllers\MailController::class,'deleteAppointment']);
//route to get send the mail to signal a problem
Route::post('/signalRequest', [App\Http\Controllers\MailController::class,'signalRequestMail']);
//route to get all appointments that are in pending
Route::get('/appointmentListPending', \App\Http\Controllers\AppointmentController::class .'@getListPending');
//route to make an appointment in confirmed
Route::post('/acceptAppointment/{id}', \App\Http\Controllers\MailController::class .'@updateConfirmed');
//route to make an appointment in refuse
Route::post('/refuseAppointment/{id}', \App\Http\Controllers\MailController::class .'@updateRefused');
//route to make a the availabilities
Route::post('/insertAvailabilities', \App\Http\Controllers\AvailabilityController::class .'@insertAvailabilities');
//route to get all the availabilities
Route::get('/getAllAvailabilities', [App\Http\Controllers\AvailabilityController::class,'getAllAvailibility']);
//route to delete the availability
Route::post('/deleteAvailability/{id}', [App\Http\Controllers\AvailabilityController::class,'deleteAvailability']);











