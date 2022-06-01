<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\DB;

use App\Models\Offer;
use App\Http\Controllers\OfferController;
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

Route::get('/', [OfferController::class,'index']);
Route::get('offers', [OfferController::class,'index']);
Route::get('offers/{offer}',[OfferController::class,'show']);
Route::get('offers/search/{searchTerm}',[OfferController::class,'findBySearchTerm']);

Route::get('users', [UserController::class,'index']);

//Post
Route::post('offers',[OfferController::class,'save']);
