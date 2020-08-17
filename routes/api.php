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

Route::middleware(['auth:api'])->group(function() {

    Route::get('/user', 'UserController@current')->name('api.users.current');

    Route::get('/users', 'UserController@all')->name('api.users.all');

    Route::get('/users/{id}', 'UserController@findById')->name('api.users.findById');

    Route::post('/users', 'UserController@store')->name('api.users.store');

    Route::put('/users/{id}', 'UserController@update')->name('api.users.update');

});