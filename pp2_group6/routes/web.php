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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', \App\Http\Controllers\AppointmentController::class . '@getIndex');

Route::post('appointments', \App\Http\Controllers\AppointmentController::class . '@store');

Route::get('appointments', \App\Http\Controllers\AppointmentController::class . '@get');

Route::delete('appointments/{id}', \App\Http\Controllers\AppointmentController::class . '@delete');
