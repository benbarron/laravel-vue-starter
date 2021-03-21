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

/**
 * Routes for registration and logging user in
 */
Route::get('/', 'HomeController@site')->name('user.home');
Route::get('/login', 'LoginController@form')->name('login');
Route::post('/login', 'LoginController@login');
Route::get('/register', 'RegisterController@form')->name('register');
Route::post('/register', 'RegisterController@register');
Route::post('/logout', 'LogoutController@post')->name('logout.post');
Route::get('/logout', 'LogoutController@get')->name('logout.get');
/**
 * Routes for requesting for a password reset link to be sent to your email,
 * verifying and finally updating password
 */
Route::get('/password/forgot', 'ForgotPasswordController@show');
Route::post('/password/forgot', 'ForgotPasswordController@send');
Route::get('/password/reset/{token}/{id}', 'ResetPasswordController@show');
Route::post('/password/reset', 'ResetPasswordController@update');

/**
 * Routes for logged in admin
 */
Route::middleware(['auth'])->group(function () {
  Route::get('/home', 'HomeController@vue')->name('dashboard.home');
  Route::get('/users', 'HomeController@vue')->name('dashboard.users');
  Route::get('/meeting', 'HomeController@vue')->name('dashboard.meeting');
});

Route::middleware(['auth', 'admin'])->group(function () {
  Route::get('/users/create', 'HomeController@vue')->name('admin.users.create');
  Route::get('/users/edit/{id}', 'HomeController@vue')->name('admin.users.edit');
});
