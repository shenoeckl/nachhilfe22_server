<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Alle Angebote
Route::get('offers',[OfferController::class, 'index']);
Route::get('offers/{id}',[OfferController::class, 'findById']);
Route::get('offers/checkId/{id}',[OfferController::class, 'checkId']);
Route::get('offers/search/{searchTerm}',[OfferController::class, 'findBySearchTerm']);

//Unterschiedlich gefiltert
Route::get('offers/status/{status}',[OfferController::class, 'findByStatus']);
Route::get('offers/user/{id}',[OfferController::class, 'findByUserId']);
//Appointments
Route::get('appointments/user/{user_id}',[AppointmentController::class, 'findByUserId']);
Route::get('appointments/status/{status}',[AppointmentController::class, 'findByStatus']);

Route::get('users',[UserController::class, 'index']);
Route::get('users/{id}',[UserController::class, 'findById']);

Route::get('appointments',[AppointmentController::class, 'index']);
Route::get('appointments/{id}',[AppointmentController::class, 'findById']);



//User - Login
Route::post('auth/login',[AuthController::class, 'login']);

//ROuten gruppieren
Route::group(['middleware'=>['api','auth.jwt']], function(){
    //Post
    Route::post('appointments',[AppointmentController::class,'save']);
    Route::post('users',[UserController::class,'save']);
    Route::post('offers',[OfferController::class,'save']);
    //Put
    Route::put('offers/{id}',[OfferController::class,'update']);
    Route::put('appointments/{id}',[AppointmentController::class,'update']);
    //Delete
    Route::delete('offers/{id}',[OfferController::class,'delete']);
    Route::delete('users',[UserController::class,'delete']);
    Route::delete('appointments/{id}',[AppointmentController::class,'delete']);
    //User - Login Logout
    Route::post('auth/logout',[AuthController::class, 'logout']);
});
