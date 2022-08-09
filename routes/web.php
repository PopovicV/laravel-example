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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/users', 'UserController@index')->name('users')->middleware('auth');
Route::get('/profile', 'UserController@showProfile')->name('profile')->middleware('auth');
Route::put('/edit/{id}', 'UserController@update')->name('edit')->middleware('auth');

Route::get('/teams', 'TeamController@index')->name('teams')->middleware('auth');
Route::get('/team/{id}', 'TeamController@show')->name('team')->middleware('auth');
