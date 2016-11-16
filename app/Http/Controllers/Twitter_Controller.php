<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AccessTokenModel;
use App\SosmedModel;

use Session;
use Socialite;

use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter_Controller extends Controller
{
	#do auth
	public function auth(){
		return Socialite::driver('twitter')->redirect();
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
			AccessTokenModel::create([
				'value' 					=> $twitter_user->token.','.$twitter_user->tokenSecret,
				'type'  					=> 'twitter'
			]);

			#get user_id from db
			$get_id 						= AccessTokenModel::where('value','=',$twitter_user->token.','.$twitter_user->tokenSecret)->get();

			#get twitter feed
			$feed 							= $this->get_feed($twitter_user->token,$twitter_user->tokenSecret);

			foreach ($feed as $key => $value) {
					$row = [];
					$row['user_id'] 		= $get_id[0]->id;
					$row['post_id'] 		= $value->id;
					$row['konten']  		= $value->text;
					$row['waktu']			= strtotime($value->created_at);
					$row['source']  		= 'twitter';
					$row['link']			= 'http://twitter.com/'.$feed[0]->user->screen_name.'/status/'.$value->id;
					$row['media']			= '';

					if (isset($value->entities->media)) {
						$row['media']		=  $value->entities->media[0]->media_url;
					}

					#insert feed to db
					SosmedModel::create($row);
			}
		}

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
