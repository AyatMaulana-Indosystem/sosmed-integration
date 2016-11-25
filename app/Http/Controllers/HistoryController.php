<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AccessTokenModel;
use App\SosmedModel;

use Session;

class HistoryController extends Controller
{
	public function __construct(){
		$this->middleware('auth_sosmed');
	}

	public function index(){
		$query 						= new SosmedModel;
		$data['sosmed'] 			= [];
		$qry 						= 'SELECT * FROM sosmed WHERE ';
		$wherIn						= [];

		if (Session::has('instagram')) {
			$data_access = AccessTokenModel::where('value','=',Session::get('instagram')['access_token'])->get();

			$data_temp['instagram'] = SosmedModel::where('user_id','=',$data_access[0]->id)->get();
			// array_push($data['sosmed'],$data_temp['instagram']);

			foreach ($data_temp['instagram'] as $key => $value) {
				array_push($data['sosmed'],$value); 
			}

			$qry .= 'user_id = "'.$data_access[0]->id.'"';
			$whereIn[] = $data_access[0]->id;
		}

		if (Session::has('facebook')) {
			$data_access = AccessTokenModel::where('value','=',Session::get('facebook')['token'])->get();

			$data_temp['facebook'] 	= SosmedModel::where('user_id','=',$data_access[0]->id)->get();
			// array_push($data['sosmed'],$data_temp['facebook']);

			foreach ($data_temp['facebook'] as $key => $value) {
				array_push($data['sosmed'],$value); 
			}

			$qry .= ' OR user_id = "'.$data_access[0]->id.'" OR ';
			$whereIn[] = $data_access[0]->id;

		}

		if (Session::has('twitter')) {
			if (isset(Session::get('twitter')['token'])) {
				$token = Session::get('twitter')['token'].','.Session::get('twitter')['tokenSecret'];
			}
			else{
				$token = Session::get('twitter')->token.','.Session::get('twitter')->tokenSecret;
			}

			$data_access = AccessTokenModel::where('value','=',$token)->get();

			$data_temp['twitter'] 	= SosmedModel::where('user_id','=',$data_access[0]->id)->get();
			// array_push($data['sosmed'],$data_temp['twitter']);

			foreach ($data_temp['twitter'] as $key => $value) {
				array_push($data['sosmed'],$value); 
			}

			$qry .= 'user_id = "'.$data_access[0]->id.'"';
			$whereIn[] = $data_access[0]->id;

		}

		// $qry .= ' ORDER BY waktu DESC';
		// $data['sosmed'] = \DB::select($qry);
		// $result = $qry;
		
		$data['sosmed'] = SosmedModel::whereIn('user_id',$whereIn)->orderBy('waktu','desc')->get();

		// return $result;
		// return $data;
		return view('history', compact('data'));
		

	}

}
