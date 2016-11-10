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
	public $twitter;

	public function auth(){
		return Socialite::driver('twitter')->redirect();
	}

	public function callback(){
		$twitter_user = Socialite::driver('twitter')->user();

		$cek = AccessTokenModel::where('value','=',$twitter_user->token)->get();

		if (count($cek) == 0) {
			AccessTokenModel::create([
				'value' => $twitter_user->token.','.$twitter_user->tokenSecret,
				'type'  => 'twitter'
			]);

			$get_id = AccessTokenModel::where('value','=',$twitter_user->token.','.$twitter_user->tokenSecret)->get();

			$twitterOAuth = new TwitterOAuth(
				env('TWITTER_CONSUMER_KEY'),
				env('TWITTER_SECRET_KEY'),
				$twitter_user->token,
				$twitter_user->tokenSecret
			);

			$feed = $twitterOAuth->get("statuses/user_timeline", ["count" => 100]);

			foreach ($feed as $key => $value) {
				// SosmedModel::create([
					$row = [];
					$row['user_id'] = $get_id[0]->id;
					$row['post_id'] = $value->id;
					$row['konten']  = $value->text;
					$row['waktu']	= strtotime($value->created_at);
					$row['source']  = 'twitter';
					$row['link']	= 'http://twitter.com/'.$feed[0]->user->screen_name.'/status/'.$value->id;
					$row['media']	= '';

					if (isset($value->entities->media)) {
							$row['media']	=  $value->entities->media[0]->media_url;
					}

					// array_push($aray, $row);
					SosmedModel::create($row);
			}

			Session::put('twitter', $twitter_user);

			return \Redirect::to('/history');
		}

		
	}
}
