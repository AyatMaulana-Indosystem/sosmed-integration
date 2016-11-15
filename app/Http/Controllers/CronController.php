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
		$count				 					= 0;

		#get all access_token from db
		$data['access_token'] 					= AccessTokenModel::all();

		foreach($data['access_token'] as $key => $value){
			
			#If Facebook Access Token
			if ($value->type == 'facebook')
			{
				#get new feed
				$new_feed						= Facebook_Controller::get_feed($value->value);

				#get new feed from db
				$get_post						= SosmedModel::where('user_id','=',$value->id)->orderBy('waktu','desc')->get();

				#If new feed != new feed from db
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
								$row['konten'] 	= $value2['message'];
							}

							if (isset($value2['attachments']['data'][0]['media']['image']['src'])) {
								$row['media'] 	= $value2['attachments']['data'][0]['media']['image']['src'];
							}

							#insert into db
							SosmedModel::create($row);
						}
					}

					$count++;
				}
			}

			#If Twitter Access Token
			if ($value->type == 'twitter')
			{
				#explode token from db
				$token 							= explode(',',$value->value);

				#get new feed
				$new_feed 						= Twitter_Controller::get_feed($token[0],$token[1]);

				#get new feed from db
				$get_post 						= SosmedModel::where('user_id','=',$value->id)->orderBy('waktu','desc')->get();


				#If new feed != new feed from db
				if (strtotime($new_feed[0]->created_at) != $get_post[0]['waktu']) 
				{
					foreach ($new_feed as $key => $value2) {

						#do checking, if time > latest time in db
						if (strtotime($value2->created_at) > $get_post[0]['waktu']) 
						{
							$row = [];
							$row['user_id'] 	= $value->id;
							$row['post_id'] 	= $value2->id;
							$row['konten']  	= $value2->text;
							$row['waktu']		= strtotime($value2->created_at);
							$row['source']  	= 'twitter';
							$row['link']		= 'http://twitter.com/'.$new_feed[0]->user->screen_name.'/status/'.$value->id;
							$row['media']		= '';

							if (isset($value2->entities->media)) {
								$row['media']	=  $value2->entities->media[0]->media_url;
							}

							#insert feed to db
							SosmedModel::create($row);
						}
					}

					$count++;
				}
			}



			// if Instagram Access Token
			if ($value->type == 'instagram')
			{
				#get new feed
				$new_feed 						= Instagram_Controller::get_feed($value->value);

				#get new feed from db
				$get_post 						= SosmedModel::where('user_id','=',$value->id)->orderBy('waktu','desc')->get();

				#If new feed != new feed from db
				if ($new_feed['data'][0]['created_time'] != $get_post[0]['waktu']) 
				{
					foreach ($new_feed['data'] as $key => $value2) 
					{

						#do checking, if time > latest time in db
						if ($value2['created_time'] > $get_post[0]['waktu']) 
						{
							#insert into db
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
				}
			}
		}

		return $count.' User Updated';

	}

	public function delete()
	{

	}
}
