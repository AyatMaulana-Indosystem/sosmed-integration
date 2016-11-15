<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AccessTokenModel;
use App\SosmedModel;

use App\Http\Controllers\Instagram_Controller;
use App\Http\Controllers\Facebook_Controller;
use App\Http\Controllers\Twitter_Controller;


class CronController extends Controller
{
	public function update()
	{
		$count				  = 0;
		$data['access_token'] = AccessTokenModel::all();

		foreach($data['access_token'] as $key => $value){
			
			#If Facebook Access Token
			if ($value->type == 'facebook')
			{
				$new_feed						= Facebook_Controller::get_feed($value->value);

				$get_post						= SosmedModel::where('user_id','=',$value->id)->orderBy('waktu','desc')->get();

				#If has new feed
				if (strtotime($new_feed['data'][0]['created_time']) != $get_post[0]['waktu'])
				{

					foreach ($new_feed['data'] as $key => $value2) {

						#do checking, if time > latest time in db
						if (strtotime($value2['created_time']) > $get_post[0]['waktu']) 
						{
							$row = [];

							$row['user_id'] 	= $value->id;
							$row['waktu'] 		= strtotime($value2['created_time']);
							$row['source'] 		= 'facebook';
							$row['link'] 		= '';
							$row['konten'] 		= '';
							$row['media'] 		= '';

							if (isset($value2['link'])) {
								$row['link'] 	= $value2['link'];
							}

							if (isset($value2['message'])) {
								// $row['konten'] = stripcslashes(json_encode($value['message']));
								$row['konten'] 	= $value2['message'];
							}

							if (isset($value2['attachments']['data'][0]['media']['image']['src'])) {
								$row['media'] 	= $value2['attachments']['data'][0]['media']['image']['src'];
							}

							#insert into db
							SosmedModel::create($row);
							unset($row);
						}
					}

					$count++;
				}
			}

			if ($value->type == 'twitter')
			{
				$token 							= explode(',',$value->value);

				#get_content from 
				$new_feed 						= Twitter_Controller::get_feed($token[0],$token[1]);
				// return strtotime($new_feed[0]->created_at);

				$get_post 						= SosmedModel::where('user_id','=',$value->id)->orderBy('waktu','desc')->get();


				// echo strtotime($new_feed[0]->created_at).' , ';
				// print_r($new_feed);

				if (strtotime($new_feed[0]->created_at) != $get_post[0]['waktu']) 
				{
					// return 1;
					foreach ($new_feed as $key => $value2) {
						// dd($new_feed);
						if (strtotime($value2->created_at) > $get_post[0]['waktu']) 
						{
							$row = [];
							$row['user_id'] 		= $value->id;
							$row['post_id'] 		= $value2->id;
							$row['konten']  		= $value2->text;
							$row['waktu']			= strtotime($value2->created_at);
							$row['source']  		= 'twitter';
							$row['link']			= 'http://twitter.com/'.$new_feed[0]->user->screen_name.'/status/'.$value->id;
							$row['media']			= '';

							if (isset($value2->entities->media)) {
								$row['media']		=  $value2->entities->media[0]->media_url;
							}

							#insert feed to db
							SosmedModel::create($row);
							// return $row;
							// echo 1;
						}
					}

					$count++;
				}
			}



			// if Instagram Access Token
			if ($value->type == 'instagram')
			{
				#get_content from 
				$new_feed 						= Instagram_Controller::get_feed($value->value);

				$get_post 						= SosmedModel::where('user_id','=',$value->id)->orderBy('waktu','desc')->get();

				if ($new_feed['data'][0]['created_time'] != $get_post[0]['waktu']) 
				{
					foreach ($new_feed['data'] as $key => $value2) {
						if ($value2['created_time'] > $get_post[0]['waktu']) 
						{
							SosmedModel::create([
								'user_id' 		=> $value->id,
								'konten'  		=> $value2['caption']['text'],
								'media'	  		=> $value2['images']['standard_resolution']['url'],
								'waktu'   		=> $value2['created_time'],
								'source'  		=> 'instagram',
								'link'    		=> $value2['link']
							]);
						}
					}

					$count++;
					// $result 					= 'Cron Successfuly running for Instagram';
				}
			}
		}

		return $count.' User Updated';
		// return $new_feed['data'][0]['created_time'];
		// return $get_post;

	}

	public function delete()
	{

	}
}
