<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AccessTokenModel;
use App\SosmedModel;

use App\Http\Controllers\CurlController;

use Redirect;
use Session;

class Instagram_Controller extends Controller
{
	public function auth(){

		#instagram auth endpoint
		$url 							= "https://api.instagram.com/oauth/access_token";
	    
		#params
	    $access_token_parameters = array(
	        'client_id'                =>     env('INSTAGRAM_CLIENT_ID'),
	        'client_secret'            =>     env('INSTAGRAM_CLIENT_SECRET'),
	        'grant_type'               =>     'authorization_code',
	        'redirect_uri'             =>     'http://localhost:8000/auth_instagram',
	        'code'                     =>     $_GET['code']
	    );

	    #do auth
		$curl 							= CurlController::get($url, $access_token_parameters, TRUE);

		#if auth success and have access token
	    if (isset($curl['access_token'])) 
	                                                                                                      {

	    	#get access token in db
			$cek 						= AccessTokenModel::where('value','=',$curl['access_token'])->get();

			#get user feed
		    $obj 						= $this->get_feed($curl['access_token']);

		    #if access_token in db = 0
			if (count($cek) == 0) 
			{
				#insert access_token into db
				AccessTokenModel::create([
					'type' 				=> 'instagram',
					'value' 			=> $curl['access_token']
				]);

				#get user_id
				$get_id 				= AccessTokenModel::where('value','=',$curl['access_token'])->get();

				foreach ($obj['data'] as $key => $value) {

					#insert feed into db
					SosmedModel::create([
						'user_id' 		=> $get_id[0]->id,
						'post_id'		=> $value['id'],
						'konten'  		=> $value['caption']['text'],
						'media'	  		=> $value['images']['standard_resolution']['url'],
						'waktu'   		=> $value['created_time'],
						'source'  		=> 'instagram',
						'link'    		=> $value['link']
					]);
				}
			}

			#put data into session
			Session::put('instagram',$curl);

			#Redirect to history
			return Redirect::to('/history');
	    }
	    else{
			#Redirect to root
			return Redirect::to('/');
	    }
	}

	public static function get_feed($token)
	{
		    $url 						= 'https://api.instagram.com/v1/users/self/media/recent?access_token='.$token;
		    $obj 						= json_decode(file_get_contents($url), true);	

		    return $obj;
	}
}
