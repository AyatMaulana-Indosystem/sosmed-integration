<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AccessTokenModel;
use App\SosmedModel;

class CronController extends Controller
{
	public function update()
	{
		$data['access_token'] = AccessTokenModel::all();

		$row = [];
		foreach($data['access_token'] as $key => $value){
			
			// If Facebook Access Token
			if ($value->type == 'facebook')
			{
				// $get_content = file_get_contents("");
			}

			// if Instagram Access Token
			if ($value->type == 'instagram')
			{
				#get_content from 
				$get_content = json_decode(file_get_contents('https://api.instagram.com/v1/users/self/media/recent?access_token='.$value['value']), true);

				$row[$value->id]=$get_content;


			}

			// If Twitter Access Token
			if ($value->type == 'twitter')
			{

			}
		}

		return $row;

	}

	public function delete()
	{

	}
}
