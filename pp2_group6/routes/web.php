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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', \App\Http\Controllers\AppointmentController::class . '@getIndex');

Route::post('appointments', \App\Http\Controllers\AppointmentController::class . '@store');

Route::get('appointments', \App\Http\Controllers\AppointmentController::class . '@get');

Route::delete('appointments/{id}', \App\Http\Controllers\AppointmentController::class . '@delete');


//
Route::get('users', \App\Http\Controllers\UserController::class . '@get');


//

Route::get('appointment/accept/{token}', \App\Http\Controllers\AppointmentController::class . '@encrypt');


Route::get('appointment/token/{token}', \App\Http\Controllers\AppointmentController::class . '@showCancelPage');

Route::delete('appointment/token/appointments/{id}', \App\Http\Controllers\AppointmentController::class . '@delete');


//Route::post('appointments/{id}', \App\Http\Controllers\AppointmentController::class . '@delete');


//Delete Item
Route::delete('appointment/delete/{id}', \App\Http\Controllers\AppointmentController::class . '@delete');

