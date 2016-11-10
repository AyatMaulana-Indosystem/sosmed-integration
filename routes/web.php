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

// Route::get('/in','Instagram_Controller@index');

// Facebook
Route::get('/auth_facebook','Facebook_Controller@auth');
Route::get('/auth_facebook/callback','Facebook_Controller@callback');
// Route::get('/facebook','Facebook_Controller@facebook');


// Check session
Route::get('/cek', function(){
	return Session::all();
});

// Twitter
Route::get('/auth_twitter','Twitter_Controller@auth');
Route::get('/auth_twitter/callback','Twitter_Controller@callback');

// Logout
Route::get('/logout/{sosmed}','LogoutController@logout');

// Cron
Route::get('/cron','CronController@index');