<?php

Route::get('/', function () {
    return view('login');
});

Route::get('/destroy', function(){
	\Session::flush();
	echo 'All Session Destroyed';
});

// history
Route::get('/history','HistoryController@index');

// Instagram
Route::get('/auth_instagram', 'Instagram_Controller@auth');

// Facebook
Route::get('/auth_facebook','Facebook_Controller@auth');
Route::get('/auth_facebook/callback','Facebook_Controller@callback');

// Twitter
Route::get('/auth_twitter','Twitter_Controller@auth');
Route::get('/auth_twitter/callback','Twitter_Controller@callback');

// Logout
Route::get('/logout/{sosmed}','LogoutController@logout');

// Route::get('/in','Instagram_Controller@index');
// Route::get('/facebook','Facebook_Controller@facebook');


// Check session
Route::get('/cek', function(){
	return Session::all();
});


// Cron
Route::get('/cron','CronController@update');


// Oflline auth
