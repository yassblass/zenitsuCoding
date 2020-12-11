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

Route::get('/request', function () {
    return view('secretary/request');
});

Route::get('/appointmentList', \App\Http\Controllers\AppointmentController::class .'@getAppointmentsInPending');


Route::post('/editAccept/{id}', \App\Http\Controllers\AppointmentController::class .'@updateAccepted');

Route::post('/editRefuse/{id}', \App\Http\Controllers\AppointmentController::class .'@updateRefused');