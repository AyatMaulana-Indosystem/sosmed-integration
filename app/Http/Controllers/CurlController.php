<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurlController extends Controller
{
	public static function get($url, $params = null, $is_post = FALSE){

		$curl = curl_init($url);    // we init curl by passing the url

		if ($is_post) {
		    curl_setopt($curl,CURLOPT_POST,true);   // to send a POST request
		}

		if (is_array($params)) {
		    curl_setopt($curl,CURLOPT_POSTFIELDS,$params);   // indicate the data to send
		}

	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);   // to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);   // to stop cURL from verifying the peer's certificate.
	    $result = curl_exec($curl);   // to perform the curl session
	    curl_close($curl);   // to close the curl session

	    return json_decode($result,true);
	}
}
