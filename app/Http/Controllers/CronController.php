<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AccessTokenModel;
use App\SosmedModel;

use App\Http\Controllers\Instagram_Controller;
use App\Http\Controllers\Facebook_Controller;
use App\Http\Controllers\Twitter_Controller;

use Abraham\TwitterOAuth\TwitterOAuth;

class CronController extends Controller
{
	public function update()
	{
		$count				 								= 0;

		#get all access_token from db
		$data['access_token'] 								= AccessTokenModel::all();

		foreach($data['access_token'] as $key => $value){
			
			#If Facebook Access Token
			if ($value->type == 'facebook')
			{
				#get new feed from db
				$get_post									= SosmedModel::where('user_id','=',$value->id)->orderBy('waktu','DESC')->first();
				
				#get new feed
				$new_feed									= $this->feed_facebook($value->value, $get_post->waktu);

				#if new feed from db = 0 row
				if (count($get_post) == 0 || count($get_post) == null) 
				{
					foreach ($new_feed['data'] as $key => $value2) 
					{
						#if new feed time > tomorrow
						if (strtotime($value2['created_time']) > strtotime(date('Y-m-d h:i:s'). "-1 days") ) {
								$row = [];
								$row['user_id'] 			= $value->id;
								$row['waktu'] 				= strtotime($value2['created_time']);
								$row['source'] 				= 'facebook';
								$row['link'] 				= '';
								$row['konten'] 				= '';
								$row['media'] 				= '';
								$row['json']				= json_encode($value2);

								if (isset($value2['link'])) {
									$row['link'] 			= $value2['link'];
								}

								if (isset($value2['message'])) {
									$row['konten'] 			= $value2['message'];
								}

								if (isset($value2['attachments']['data'][0]['media']['image']['src'])) {
									$row['media'] 			= $value2['attachments']['data'][0]['media']['image']['src'];
								}

								#insert into db
								SosmedModel::create($row);

								$count++;
						}
					}	
				}
				else
				{

						foreach ($new_feed['data'] as $key => $value2) {

							#do checking, if time > latest time in db
							if (strtotime($value2['created_time']) > $get_post->waktu) 
							{
								$row = [];
								$row['user_id'] 			= $value->id;
								$row['waktu'] 				= strtotime($value2['created_time']);
								$row['source'] 				= 'facebook';
								$row['link'] 				= '';
								$row['konten'] 				= '';
								$row['media'] 				= '';
								$row['json']				= json_encode($value2);


								if (isset($value2['link'])) {
									$row['link'] 			= $value2['link'];
								}

								if (isset($value2['message'])) {
									$row['konten'] 			= $value2['message'];
								}

								if (isset($value2['attachments']['data'][0]['media']['image']['src'])) {
									$row['media'] 			= $value2['attachments']['data'][0]['media']['image']['src'];
								}

								#insert into db
								SosmedModel::create($row);
							}

							$count++;
						}

				}
			}

			#If Twitter Access Token
			if ($value->type == 'twitter')
			{
				#explode token from db
				$token 										= explode(',',$value->value);

				#get new feed from db
				$get_post 									= SosmedModel::where('user_id','=',$value->id)->orderBy('waktu','desc')->first();

				#get new feed
				$new_feed 									= $this->feed_twitter($token[0],$token[1],$get_post->post_id);

				// dd($new_feed);
				// die();

				#if new feed from db = 0 row
				if (count($get_post) == 0 || count($get_post) == null) 
				{
					foreach ($new_feed as $key => $value2) {

						#if new feed time > tomorrow
						if (strtotime($value2->created_at) > strtotime(date('Y-m-d h:i:s'). "-1 days")) 
						{
								$row = [];
								$row['user_id'] 			= $value->id;
								$row['post_id'] 			= $value2->id_str;
								$row['konten']  			= $value2->text;
								$row['waktu']				= strtotime($value2->created_at);
								$row['source']  			= 'twitter';
								$row['link']				= 'http://twitter.com/'.$new_feed[0]->user->screen_name.'/status/'.$value2->id;
								$row['media']				= '';
								$row['json']				= json_encode($value2);


								if (isset($value2->entities->media)) {
									$row['media']			=  $value2->entities->media[0]->media_url;
								}

								#insert feed to db
								SosmedModel::create($row);

								$count++;
						}
					}
				}
				else
				{

					if (count($new_feed) != 0) {

						foreach ($new_feed as $key => $value2) {

							#do checking, if time > latest time in db
							// if (strtotime($value2->created_at) > $get_post->waktu) 
							// {
								$row = [];
								$row['user_id'] 			= $value->id;
								$row['post_id'] 			= $value2->id_str;
								$row['konten']  			= $value2->text;
								$row['waktu']				= strtotime($value2->created_at);
								$row['source']  			= 'twitter';
								$row['link']				= 'http://twitter.com/'.$new_feed[0]->user->screen_name.'/status/'.$value2->id;
								$row['media']				= '';
								$row['json']				= json_encode($value2);


								if (isset($value2->entities->media)) {
									$row['media']			=  $value2->entities->media[0]->media_url;
								}

								#insert feed to db
								SosmedModel::create($row);
							// }

							$count++;

						}
					}
				}
			}



			// if Instagram Access Token
			if ($value->type == 'instagram')
			{
				#get new feed
				$new_feed 									= Instagram_Controller::get_feed($value->value);

				#get new feed from db
				$get_post 									= SosmedModel::where('user_id','=',$value->id)->orderBy('waktu','desc')->first();

				#if new feed from db = 0 row
				if (count($get_post) == 0) 
				{
					foreach ($new_feed['data'] as $key => $value2) 
					{
						#if new feed time > tomorrow
						if ($value2['created_time'] > strtotime(date('Y-m-d h:i:s'). "-1 days")) 
						{
							$row['user_id'] 				= $value->id;
							$row['konten']  				= '';
							$row['media']	  				= $value2['images']['standard_resolution']['url'];
							$row['waktu']   				= $value2['created_time'];
							$row['source']  				= 'instagram';
							$row['link']    				= $value2['link'];
							$row['json']					= json_encode($value2);

							if (isset($value2['caption']['text'])) 
							{
								$row['konten']  			= $value2['caption']['text'];
							}

							#insert into db
							SosmedModel::create($row);

							$count++;
						}
					}
				}
				else
				{

					#If new feed != new feed from db
					if ($new_feed['data'][0]['created_time'] != $get_post->waktu) 
					{
						foreach ($new_feed['data'] as $key => $value2) 
						{

							#do checking, if time > latest time in db
							if ($value2['created_time'] > $get_post->waktu) 
							{
								$row['user_id'] 			= $value->id;
								$row['konten']  			= '';
								$row['media']	  			= $value2['images']['standard_resolution']['url'];
								$row['waktu']   			= $value2['created_time'];
								$row['source']  			= 'instagram';
								$row['link']    			= $value2['link'];
								$row['json']				= json_encode($value2);


								if (isset($value2['caption']['text'])) 
								{
									$row['konten']  		= $value2['caption']['text'];
								}

								#insert into db
								SosmedModel::create($row);
							}
						}

						$count++;
					}
				}

			}
		}

		return $count.' Post Updated';
	}

	public function delete()
	{
		echo 'cron running.... <br>';

		#create var for count 
		$count 												= 0;

		#create var for time now
		$now 												= time();

		#get all access_token from db
		$data['access_token'] 								= AccessTokenModel::all();

		foreach ($data['access_token'] as $key => $value) {

				#get feed from db
				$get_feed 									= SosmedModel::where('user_id','=',$value->id)->orderBy('waktu','desc')->get();

				#create var id
				$id 										= [];

				foreach ($get_feed as $key => $value2) 
				{
					#expire date for post (30 day)
					$exp 									= strtotime(date('Y-m-d h:i:s',$value2->waktu). '+30 days');

					#checking if expire date < now
					if ($exp < $now) {

						#push to var id
						$id[]  								=  $value2->id;

						#incrementing count
						$count++;
					}
				}

				#delete in db by id
				SosmedModel::destroy($id);
		}

		echo $count.' Post delete';
	}


	public function feed_facebook($token, $since)
	{
			$feed 											= file_get_contents(env('FACEBOOK_API')."me/posts?access_token=".$token."&fields=id,story,created_time,message,link,attachments{media}&limit=100&since=".$since);
			$obj 											= json_decode($feed,true);

			return $obj;
	}

	public function feed_twitter($token,$tokenSecret,$since_id)
	{
			#set params to get twiter_feed
			$twitterOAuth 									= new TwitterOAuth(
				env('TWITTER_CONSUMER_KEY'),
				env('TWITTER_SECRET_KEY'),
				$token,
				$tokenSecret
			);

			#get twitter feed
			$feed 							= $twitterOAuth->get("statuses/user_timeline", [
												"count" 	=> 100,
												"since_id"  => $since_id
											]);

			return $feed;
	}

}
