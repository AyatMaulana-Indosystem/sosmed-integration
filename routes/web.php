<?php

Route::get('/', function () {
    return view('login');
});


// history
Route::get('/history',					'HistoryController@index');

// Instagram
Route::get('/auth_instagram', 			'Instagram_Controller@auth');

// Facebook
Route::get('/auth_facebook',			'Facebook_Controller@auth');
Route::get('/auth_facebook/callback',	'Facebook_Controller@callback');

// Twitter
Route::get('/auth_twitter',				'Twitter_Controller@auth');
Route::get('/auth_twitter/callback',	'Twitter_Controller@callback');

// Logout
Route::get('/logout/{sosmed}',			'LogoutController@logout');



// Check session
Route::get('/cek', function(){
	return Session::all();
});

Route::get('/destroy', function(){
	\Session::flush();
	echo 'All Session Destroyed';
});

// Cron
Route::get('/cron-update','CronController@update');
Route::get('/cron-delete','CronController@delete');
