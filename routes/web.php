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

Auth::routes();

Route::group(['middleware' => ['auth']], function (){

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('person', \App\Http\Controllers\Web\PersonController::class, ['names'=> 'person']);
    Route::resource('bag', \App\Http\Controllers\Web\BagController::class, ['names'=> 'person']);
    Route::resource('user', \App\Http\Controllers\UserController::class, ['names' => 'user']);

});
