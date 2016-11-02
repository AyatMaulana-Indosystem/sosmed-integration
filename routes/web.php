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


Route::get('/history', function(){
	return view('history');
});

Route::get('/auth_instagram', function(){

	$url = "https://api.instagram.com/oauth/access_token";
    $access_token_parameters = array(
        'client_id'                =>     env('INSTAGRAM_CLIENT_ID'),
        'client_secret'            =>     env('INSTAGRAM_CLIENT_SECRET'),
        'grant_type'               =>     'authorization_code',
        'redirect_uri'             =>     'http://localhost:8000/auth_instagram',
        'code'                     =>     $_GET['code']
    );

	$curl = curl_init($url);    // we init curl by passing the url
    curl_setopt($curl,CURLOPT_POST,true);   // to send a POST request
    curl_setopt($curl,CURLOPT_POSTFIELDS,$access_token_parameters);   // indicate the data to send
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);   // to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);   // to stop cURL from verifying the peer's certificate.
    $result = curl_exec($curl);   // to perform the curl session
    curl_close($curl);   // to close the curl session

    $arr = json_decode($result,true);

    $url = 'https://api.instagram.com/v1/users/self/media/recent?access_token='.$arr['access_token'].'&count=100';
    $hasil = file_get_contents($url);
    $obj = json_decode($hasil, true);

    // return count($obj['data']);
    return $arr;
    // return $obj;
});