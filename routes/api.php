<?php

use App\Http\Controllers\UserController;
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


Route::group(['middleware' => 'auth:sanctum'], function(){
    //Person Route
    Route::resource('person',\App\Http\Controllers\API\PersonController::class);

    //Bags Route
    Route::resource('bag',\App\Http\Controllers\API\BagController::class);

    //Logout Route
    Route::post('logout', [UserController::class, 'logout']);
    //Update Users Route
    Route::post("update",[UserController::class,'update']);
});

Route::post('register', [UserController::class, 'register']);
Route::post("login",[UserController::class,'index']);
Route::resource('user',UserController::class);
