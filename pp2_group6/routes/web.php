<?php
use \App\Http\Controllers;
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

Route::get('/{any}', function () {
    return view('dashboard');
})->where('any','.*');

//Route::post('logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::get('/request', function () {
    return view('secretary/request');
});

Route::get('/appointmentList', \App\Http\Controllers\AppointmentController::class .'@getInPending');



Route::get('/manageAppointment', function () {
    return view('secretary/appointment');
});

//nh
Route::get('/appointmentLists', [App\Http\Controllers\AppointmentController::class,'getConfirmed']);

Route::post('/formSubmit', [App\Http\Controllers\MailController::class,'sendAlert']);

Route::get('/', \App\Http\Controllers\AppointmentController::class . '@getIndex');

// Route::post('appointments', \App\Http\Controllers\AppointmentController::class . '@store');

// Route::get('appointments', \App\Http\Controllers\AppointmentController::class . '@get');



//ALL ROUTES WITH 'users' PREFIX.
Route::group(['prefix' => 'users'], function (){

    //Fetch all user from DB
    Route::get('/get', \App\Http\Controllers\UserController::class . '@get');

    

});


//ALL ROUTES WITH 'subjects' PREFIX.
Route::group(['prefix' => 'subjects'], function (){


    //Fetch all user from DB
    Route::get('/get', \App\Http\Controllers\SubjectController::class . '@get');


});




//ALL ROUTES WITH 'appointment' PREFIX.
Route::group(['prefix' => 'appointment'], function () {

    //Make an appointment request [POST]
    Route::post('create/', \App\Http\Controllers\AppointmentController::class . '@makeRequest');

    //Get all appointments [GET]
    Route::get('get', \App\Http\Controllers\AppointmentController::class . '@get');

    //Update an appointment [POST]
    Route::post('update/', \App\Http\Controllers\AppointmentController::class . '@updateAppointment');

    //Confirm an appointment [GET]
    Route::get('confirm/{appointmentId}', \App\Http\Controllers\AppointmentController::class . '@confirmAppointment');
    

    //Show Cancel Page based on TOKEN [GET]
    Route::get('token/{token}', \App\Http\Controllers\AppointmentController::class . '@showCancelPage')->name('showCancelPage');

    //Delete an appointment based on Appointment ID [DELETE]
    Route::delete('delete/{appointmentId}', \App\Http\Controllers\AppointmentController::class . '@delete');

    //Delete an appointment based on ID [DELETE]
    Route::delete('cancel/{appointmentId}', \App\Http\Controllers\AppointmentController::class . '@cancelAppointment');

    //
    Route::get('/token/appointments', \App\Http\Controllers\AppointmentController::class . '@returnView');


});
































//------------------------------------------------------------------------------------------------------------------------------------

//OLD ROUTES. WILL MAYBE BE REUSED.




//Route::delete('appointments/{id}', \App\Http\Controllers\AppointmentController::class . '@delete');

//Route::post('appointment/accept/{token}', \App\Http\Controllers\AppointmentController::class . '@encrypt');

//Route::post('appointment/accept/', \App\Http\Controllers\AppointmentController::class . '@makeRequest');

//Update an appointment status route

//Route::post('appointment/update/', \App\Http\Controllers\AppointmentController::class . '@updateAppointment');

//Route::get('appointment/update/{appointmentId}', \App\Http\Controllers\AppointmentController::class . '@confirmAppointment');

//Route::get('appointment/token/{token}', \App\Http\Controllers\AppointmentController::class . '@showCancelPage')->name('showCancelPage');

//Route::delete('appointment/token/appointments/{id}', \App\Http\Controllers\AppointmentController::class . '@delete');


//Route::post('appointments/{id}', \App\Http\Controllers\AppointmentController::class . '@delete');

//Delete Item
//Route::delete('appointment/delete/{id}', \App\Http\Controllers\AppointmentController::class . '@deleteApp');
