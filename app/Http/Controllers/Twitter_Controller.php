<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AccessTokenModel;
use App\SosmedModel;

use Session;
use Socialite;
use Redirect;

use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter_Controller extends Controller
{
	#do auth
	public function auth(){
		$check_token						= AccessTokenModel::where('type','=','twitter')->get();

		if (count($check_token) == 0) {
			return Socialite::driver('twitter')->redirect();
		}
		else{
			Session::put('twitter',json_decode($check_token[0]->json,TRUE));

			return Redirect::to('/history');
		}
	}

	#callback
	public function callback(){

		#get twitter_data from socialite
		$twitter_user 						= Socialite::driver('twitter')->user();

		#merge token & tokenSecret
		$token_db 							= $twitter_user->token.','.$twitter_user->tokenSecret;

		#cek access_token from db
		$cek 								= AccessTokenModel::where('value','=',$token_db)->get();

		#if access_token from db = 0
		if (count($cek) == 0) {

			#insert access_token into db
			$insert 						= AccessTokenModel::create([
				'value' 					=> $twitter_user->token.','.$twitter_user->tokenSecret,
				'type'  					=> 'twitter',
				'valid'						=> '1',
				'valid_until'       		=> '',
				'machine_id'        		=> '',
				'json'						=> json_encode($twitter_user),

			]);

			#get user_id from db
			$user_id 						= $insert->id;

			#get twitter feed
			$feed 							= $this->get_feed($twitter_user->token,$twitter_user->tokenSecret);
			// return $feed;

			foreach ($feed as $key => $value) {
					$row = [];
					$row['user_id'] 		= $user_id;
					$row['post_id'] 		= $value->id_str;
					$row['konten']  		= $value->text;
					$row['waktu']			= strtotime($value->created_at);
					$row['source']  		= 'twitter';
					$row['link']			= 'http://twitter.com/'.$feed[0]->user->screen_name.'/status/'.$value->id;
					$row['media']			= '';
					$row['json']			= json_encode($value);

					if (isset($value->entities->media)) {
						$row['media']		=  $value->entities->media[0]->media_url;
					}

					// $rs[] = $row;
					#insert feed to db
					SosmedModel::create($row);
			}
		}

		// return $rs;

		#put data into session
		Session::put('twitter', $twitter_user);

		#redirect to history
		return \Redirect::to('/history');

	}

	public static function get_feed($token,$tokenSecret)
	{
			#set params to get twiter_feed
			$twitterOAuth 					= new TwitterOAuth(
				env('TWITTER_CONSUMER_KEY'),
				env('TWITTER_SECRET_KEY'),
				$token,
				$tokenSecret
			);

			#get twitter feed
			$feed 							= $twitterOAuth->get("statuses/user_timeline", ["count" => 100]);

			return $feed;
	}
}
