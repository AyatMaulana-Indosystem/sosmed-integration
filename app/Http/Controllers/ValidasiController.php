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

	public static function facebook_token_regenerate($exp_token){
		$step_2 					= env('FACEBOOK_API')."oauth/client_code?";
		$step_2 					.= "access_token=".$exp_token."&";
		$step_2 					.= "client_secret=".env("FACEBOOK_SECRET_KEY")."&";
		$step_2 					.= "redirect_uri=".env("FACEBOOK_REDIRECT_URI")."&";
		$step_2 					.= "client_id=".env("FACEBOOK_APP_ID");
		$step_2 					= file_get_contents($step_2);
		$step_2_rslt 				= json_decode($step_2, true); //code


		$step_3 					= env('FACEBOOK_API')."oauth/access_token?";
		$step_3 					.= "code=".$step_2_rslt['code']."&";
		$step_3 					.= "client_id=".env("FACEBOOK_APP_ID")."&";
		$step_3 					.= "redirect_uri=".env("FACEBOOK_REDIRECT_URI");
		$step_3 					= file_get_contents($step_3, true);
		$step_3_rslt 				= json_decode($step_3, true);

		// dd($step_3_rslt);
		// echo $step_3_rslt['access_token'];
		// die();

		return $step_3_rslt;
	}

}
