<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AccessTokenModel;
use App\SosmedModel;

use App\Http\Controllers\CurlController;

use Redirect;
use Session;

class Instagram_Controller extends Controller
{
	public function auth(){

		$url = "https://api.instagram.com/oauth/access_token";
	    $access_token_parameters = array(
	        'client_id'                =>     env('INSTAGRAM_CLIENT_ID'),
	        'client_secret'            =>     env('INSTAGRAM_CLIENT_SECRET'),
	        'grant_type'               =>     'authorization_code',
	        'redirect_uri'             =>     'http://localhost:8000/auth_instagram',
	        'code'                     =>     $_GET['code']
	    );

		$curl = CurlController::get($url, $access_token_parameters, TRUE);

	    if (isset($curl['access_token'])) {
			$cek = AccessTokenModel::where('value','=',$curl['access_token'])->get();

		    $url = 'https://api.instagram.com/v1/users/self/media/recent?access_token='.$curl['access_token'];
		    $hasil = file_get_contents($url);
		    $obj = json_decode($hasil, true);

			if (count($cek) == 0) {

				AccessTokenModel::create([
					'type' => 'instagram',
					'value' => $curl['access_token']
				]);

				$get_id = AccessTokenModel::where('value','=',$curl['access_token'])->get();
				$aray = [];
				foreach ($obj['data'] as $key => $value) {
					SosmedModel::create([
						'user_id' => $get_id[0]->id,
						'konten'  => stripcslashes(json_encode($value['caption']['text'])),
						'media'	  => $value['images']['standard_resolution']['url'],
						'waktu'   => $value['created_time'],
						'source'  => '',
						'link'    => $value['link']
					]);
					// array_push($aray, );
				}
			}

			Session::put('instagram',$curl);

			return Redirect::to('/history');
	    }
	    else{
	    	echo 'fail';
	    }
	}

	public function index(){
		foreach (SosmedModel::all() as $key => $value) {
			echo json_encode(stripcslashes($value->konten)),'<br><br><br>';
		}
	}
}
