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

Route::get('/appointment', function () {
    return view('secretary/appointment');
});

Route::get('/appointmentList', [App\Http\Controllers\AppointmentController::class,'index']);
Route::delete('/appointment/{id}', [App\Http\Controllers\AppointmentController::class,'delete']);

Route::post('/formSubmit', [App\Http\Controllers\MailController::class,'formSubmit']);
Route::post('/cancelSubmit', [App\Http\Controllers\MailController::class,'cancelSubmit']);