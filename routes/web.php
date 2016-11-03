<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::get('/destroy', function(){
	\Session::flush();
	echo 'All Session Destroyed';
});

Route::get('/auth_instagram', 'Instagram_Controller@auth');
Route::get('/history','HistoryController@index');

Route::get('/in','Instagram_Controller@index');