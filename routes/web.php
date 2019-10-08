<?php

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
// Route::get('/test','FirebaseController@index');
Route::post('/test','FirebaseController@create');
Route::get('/show','FirebaseController@show');
Route::put('/update/{StudentEmailKey}','FirebaseController@update');
Route::delete('/delete/{StudentEmailKey}','FirebaseController@delete');

Route::post('/test2','SupervisorController@create');
Route::get('/show2','SupervisorController@show');
Route::put('/update2/{SupervisorEmailKey}','SupervisorController@update');
Route::delete('/delete2/{SupervisorEmailKey}','SupervisorController@delete');

Route::post('/test3','driverController@create');
Route::get('/show3','driverController@show');
Route::put('/update3/{DriverPhone}','driverController@update');
Route::delete('/delete3/{DriverPhone}','driverController@delete');

Route::post('/test4','busController@create');
Route::get('/show4','busController@show');
Route::put('/update4/{BusKey}','busController@update');
Route::delete('/delete4/{BusName}','busController@delete');

Route::post('/test5/{BusKey}','busController@createStation');
Route::get('/show5/{BusKey}','busController@showStation');
Route::put('/update5/{BusKey}/{stationKey}','busController@updateStation');
Route::delete('/delete5/{BusKey}/{stationKey}','busController@deleteStation');
Route::get('/dashdata','dashController@show');
Route::get('/violation','dashController@getviolation');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('{path}',"HomeController@index")->where('path','[A-z]*');

Route::get('Bus/{path}',"HomeController@index")->where('path','[A-z0-9]*');

