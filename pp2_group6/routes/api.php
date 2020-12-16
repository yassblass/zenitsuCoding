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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/authenticated', function () {
    return true;
});

Route::post('register', [App\Http\Controllers\RegisterController::class, 'register']);
Route::post('login', [App\Http\Controllers\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\LoginController::class, 'logout']);

Route::get('/appointmentLists', [App\Http\Controllers\AppointmentController::class,'getConfirmed']);
Route::post('/cancelAppointment/{id}', [App\Http\Controllers\MailController::class,'cancelAppointment']);
Route::post('/sendAlert', [App\Http\Controllers\MailController::class,'sendAlert']);

Route::get('/appointmentList', \App\Http\Controllers\AppointmentController::class .'@getPending');
Route::post('/editAccept/{id}', \App\Http\Controllers\MailController::class .'@updateConfirmed');
Route::post('/editRefuse/{id}', \App\Http\Controllers\MailController::class .'@updateRefused');


