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
			// return \Redirect::to('auth_facebook/callback');

			$user = Socialite::driver('facebook')->user();

			$cek = AccessTokenModel::where('value','=',$user->token)->get();

			if (count($cek) == 0) {
				AccessTokenModel::create([
					'value' => $user->token,
					'type' => 'facebook'
				]);

				$get_id = AccessTokenModel::where('value','=',$user->token)->get();

				// Get User Feed;
				$feed = file_get_contents("https://graph.facebook.com/me/posts?access_token=".$user->token."&fields=id,story,created_time,message,link,attachments{media}&limit=100");
				$obj = json_decode($feed,true);

				// var_dump($obj['data'][0]['attachments']['data'][0]['media']['image']['src']);
				// die();

				$aray = [];
				$a = 1;
				foreach ($obj['data'] as $key => $value) {
					$row = [];

					$row['user_id'] = $get_id[0]->id;
					$row['waktu'] = $value['created_time'];
					$row['source'] = 'facebook';
					$row['link'] = '';
					$row['konten'] = '';
					$row['conten'] = '';






					// array_push($aray, [
					// 	'user_id' => $get_id[0]->id,
					// 	'konten'  => stripcslashes(json_encode($value->message)),
					// 	'media'	  => $value->attachments['data'][0]->media->image->src,
					// 	'waktu'   => $value->created_time,
					// 	'source'  => 'facebook',
					// 	'link'    => $value->link
					// ]);

					if (isset($value['link'])) {
						$row['link'] = $value['link'];
					}

					if (isset($value['message'])) {
						$row['konten'] = stripcslashes(json_encode($value['message']));
					}

					if (isset($value['attachments']['data'][0]['media']['image']['src'])) {
						$row['conten'] = $value['attachments']['data'][0]['media']['image']['src'];
					}

					SosmedModel::create($row);


					// array_push($aray, $row);
				}


				// print_r($aray);

				// print_r($obj);
			}


			Session::put('facebook',$user);
			return Redirect::to('history');

		}
		else{
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

	public function callback(){
		$user = Socialite::driver('facebook')->user();

		return $user;
	}

	public function facebook(){
		return 1;
	}
}
