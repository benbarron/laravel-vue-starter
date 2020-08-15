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

Route::get('/', 'HomeController@site')->name('user.home');

Route::get('/login', 'LoginController@form')->name('login');
Route::post('/login', 'LoginController@login');

Route::get('/register', 'RegisterController@form')->name('register');
Route::post('/register', 'RegisterController@register');

Route::post('/password/request', 'PasswordController@request')->name('password.request');

Route::post('/logout', 'LogoutController@logout')->name('logout');

Route::middleware(['auth', 'admin'])->group(function() {
  Route::get('/home', 'HomeController@vue')->name('admin.home');
  Route::get('/users', 'HomeController@vue')->name('admin.users');
  Route::get('/users/create', 'HomeController@vue')->name('admin.users.create');
  Route::get('/users/edit/{id}', 'HomeController@vue')->name('admin.users.edit');
});

Route::get('/test/users', function() {
  return \App\Http\Models\User::all();
});
