<?php

namespace App\Http\Controllers;

use Session;
use Redirect;

use Illuminate\Http\Request;
use Socialite;

use App\AccessTokenModel;
use App\SosmedModel;


class Facebook_Controller extends Controller
{
	public function auth(){
		if (isset($_GET['code'])) {

			# get user info
			$user 						= Socialite::driver('facebook')->user();

			#Get Long Access Token
			$user 						= $this->getLongToken($user->token);

			#Get Access Token from db
			$cek 						= AccessTokenModel::where('value','=',$user['token'])->get();

			#If Access Token db = 0
			if (count($cek) == 0) {

				#Store Access Token
				$insert 				= AccessTokenModel::create([
					'value' 			=> $user['token'],
					'type' 				=> 'facebook'
				]);

				#Get user_id from latest Access Token
				$user_id 				= $insert->id;

				#Get User Feed;
				$obj 					= $this->get_feed($user['token']);

				#insert user feed to db
				foreach ($obj['data'] as $key => $value) {
					$row = [];

					$row['user_id'] 	= $user_id;
					$row['post_id']		= $value['id'];
					$row['waktu'] 		= strtotime($value['created_time']);
					$row['source'] 		= 'facebook';
					$row['link'] 		= '';
					$row['konten'] 		= '';
					$row['media'] 		= '';
					$row['json']		= json_decode($value);

					if (isset($value['link'])) {
						$row['link'] 	= $value['link'];
					}

					if (isset($value['message'])) {
						// $row['konten'] = stripcslashes(json_encode($value['message']));
						$row['konten'] 	= $value['message'];
					}

					if (isset($value['attachments']['data'][0]['media']['image']['src'])) {
						$row['media'] 	= $value['attachments']['data'][0]['media']['image']['src'];
					}

					#insert into db
					SosmedModel::create($row);
				}
			}

			#Put data into Session
			Session::put('facebook',$user);

			#Redirect to history
			return Redirect::to('history');
		}
		else{

			#Do facebook auth
			return Socialite::driver('facebook')->scopes([
				'email',
				'publish_actions',
				'user_about_me',
				'user_likes',
				'user_location',
				'user_photos',
				'user_posts',
				'user_status',
				'user_tagged_places',
				'user_videos',
				'pages_manage_instant_articles'
			])->redirect();
		}
	}

	public function getLongToken($access_token)
	{
		$step_1 					= "https://graph.facebook.com/oauth/access_token?";
		$step_1 					.= "grant_type=fb_exchange_token&";
		$step_1 					.= "client_id=".env("FACEBOOK_APP_ID")."&";
		$step_1 					.= "client_secret=".env("FACEBOOK_SECRET_KEY")."&";
		$step_1 					.= "fb_exchange_token=".$access_token;
		$step_1 					= file_get_contents($step_1);
		$step_1_rslt 				= substr($step_1, 13);

		$step_2 					= "https://graph.facebook.com/oauth/client_code?";
		$step_2 					.= "access_token=".$step_1_rslt."&";
		$step_2 					.= "client_secret=".env("FACEBOOK_SECRET_KEY")."&";
		$step_2 					.= "redirect_uri=".env("FACEBOOK_REDIRECT_URI")."&";
		$step_2 					.= "client_id=".env("FACEBOOK_APP_ID");
		$step_2 					= file_get_contents($step_2);
		$step_2_rslt 				= json_decode($step_2, true); //code


		$step_3 					= "https://graph.facebook.com/oauth/access_token?";
		$step_3 					.= "code=".$step_2_rslt['code']."&";
		$step_3 					.= "client_id=".env("FACEBOOK_APP_ID")."&";
		$step_3 					.= "redirect_uri=".env("FACEBOOK_REDIRECT_URI");
		$step_3 					= file_get_contents($step_3, true);
		$step_3_rslt 				= json_decode($step_3, true);

		$data['token'] 				= $step_3_rslt['access_token'];

		// getting Picture and Name
		$get_content 				= file_get_contents("https://graph.facebook.com/me?fields=id,name,picture&access_token=".$step_3_rslt['access_token']);
		$data['profile'] 			= json_decode($get_content, true);
		
		return $data;
	}

	public static function get_feed($token)
	{
			$feed 					= file_get_contents("https://graph.facebook.com/me/posts?access_token=".$token."&fields=id,story,created_time,message,link,attachments{media}&limit=100");
			$obj 					= json_decode($feed,true);

			return $obj;
	}
}
