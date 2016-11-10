<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
	public function logout($sosmed){
		if ($sosmed == 'facebook' | $sosmed == 'twitter' | $sosmed == 'instagram') {
			\Session::forget($sosmed);
			return \Redirect::to('/');
		}
		else{
			return \Redirect::to('/');
		}
	}
}
