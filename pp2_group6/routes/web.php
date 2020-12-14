<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});





Route::prefix('admin')->group(function () {
    Route::get('/users', function () {
        // Matches The "/admin/users" URL
    });
});





Route::prefix('secretary')->group( function ()  {
    //Returns the manage appointments page
    Route::get('/manageAppointment', function () {
        return view('secretary/appointment');
    });
    
    //Returns the manage appointment request page
    Route::get('/manageRequest', function () {
        return view('secretary/manageRequest');
    });

    //Returns the manage availabilities page 
    Route::get('/availabilities', function () {
        return view('secretary/setAvailability');
    });

    //Get all apointments where status = confirmed.
    Route::get('/appointmentList', [App\Http\Controllers\AppointmentController::class,'index']);

    //Send feedback alert to admin.
    Route::post('/submitAlert', [App\Http\Controllers\MailController::class,'sendAlert']);
    
    //
    Route::post('/cancelAppointment', [App\Http\Controllers\MailController::class,'cancelAppointment']);

    //
    Route::get('/getPendingAppointments', \App\Http\Controllers\AppointmentController::class .'@getPendingAppointments');

    //
    Route::post('/confirmAppointment/{id}', \App\Http\Controllers\AppointmentController::class .'@confirmAppointment');

    //
    Route::post('/refuseAppointment/{id}', \App\Http\Controllers\AppointmentController::class .'@refuseAppointment');

    Route::post('/insertAvailabilities', \App\Http\Controllers\AvailabilityController::class .'@insertAvailabilities');


    
    //Not used for now.
    //Route::delete('/delete/{id}', [App\Http\Controllers\AppointmentController::class,'delete']);
});





