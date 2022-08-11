<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/users', 'Web\UserWebController@index')->name('users')->middleware('auth');
Route::get('/profile', 'Web\UserWebController@showProfile')->name('profile')->middleware('auth');
Route::put('/edit/{id}', 'Web\UserWebController@update')->name('edit')->middleware('auth');
Route::get('/teams', 'Web\TeamWebController@index')->name('teams')->middleware('auth');
Route::get('/team/{id}', 'Web\TeamWebController@show')->name('team')->middleware('auth');
