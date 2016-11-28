<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ValidasiController extends Controller
{
	# return boolean
	public static function facebook_token_validation($token)
	{
		$url				= env('FACEBOOK_API').'debug_token?';
		$url				.= 'input_token='.$token.'&';
		$url				.= 'access_token='.$token;

		$grab				= json_decode(file_get_contents($url),TRUE);

		if(isset($grab['data']['is_valid']))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	public static function facebook_token_regenerate(){
		
	}

}
