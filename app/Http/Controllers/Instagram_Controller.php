<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AccessTokenModel;
use App\SosmedModel;

use App\Http\Controllers\CurlController;

use Redirect;
use Session;
use Socialite;

class Instagram_Controller extends Controller
{
	public function auth(){

		$check_token						= AccessTokenModel::where('type','=','instagram')->get();

		if (count($check_token) == 0) {
	
			#instagram auth endpoint
			$url 							= env('INSTAGRAM_API')."oauth/access_token";
		    
			#params
		    $access_token_parameters = array(
		        'client_id'                =>     env('INSTAGRAM_CLIENT_ID'),
		        'client_secret'            =>     env('INSTAGRAM_CLIENT_SECRET'),
		        'grant_type'               =>     'authorization_code',
		        'redirect_uri'             =>     env('INSTAGRAM_REDIRECT_URI'), 
		        'code'                     =>     $_GET['code']
		    );

		    #do auth
			$curl 							= CurlController::get($url, $access_token_parameters, TRUE);
		
			// return $curl;

			#if auth success and have access token
		    if (isset($curl['access_token'])) 
		                                                                                                      {

		    	#get access token in db
				$cek 						= AccessTokenModel::where('value','=',$curl['access_token'])->get();

				#get user feed
			    $obj 						= $this->get_feed($curl['access_token']);
				
				#insert access_token into db
				$insert 				= AccessTokenModel::create([
					'type' 				=> 'instagram',
					'value' 			=> $curl['access_token'],
					'valid'				=> '1',
					'valid_until'       => '',
					'machine_id'        => '',
					'json'				=> json_encode($curl) 
				]);

				#get user_id
				$user_id 				= $insert->id;

				foreach ($obj['data'] as $key => $value) {

					$row['user_id'] 		= $user_id;
					$row['konten']  		= '';
					$row['media']	  		= $value['images']['standard_resolution']['url'];
					$row['waktu']   		= $value['created_time'];
					$row['source']  		= 'instagram';
					$row['link']    		= $value['link'];
					$row['json']			= json_encode($value);

					if (isset($value['caption']['text'])) 
					{
						$row['konten']  	= $value['caption']['text'];
					}

					#insert feed into db
					SosmedModel::create($row);
				}
			#put data into session
			Session::put('instagram',$curl);

			#Redirect to history
			return Redirect::to('/history');
			}
		}
	    else{

	    	$get_token  					= AccessTokenModel::where('type','=','instagram')->first();

	    	$instagram_token 				= json_decode($get_token->json,TRUE);
			
			Session::put('instagram',$instagram_token);

			#Redirect to root
			return Redirect::to('/history');
	    }
	}

	public static function get_feed($token)
	{
		    $url 						= env('INSTAGRAM_API').'v1/users/self/media/recent?access_token='.$token;
		    $obj 						= json_decode(file_get_contents($url), true);	

		    return $obj;
	}
}
