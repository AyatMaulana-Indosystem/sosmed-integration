<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AccessTokenModel;
use App\SosmedModel;

use Session;

class HistoryController extends Controller
{
	public function index(){
		
		$query = new SosmedModel;

		if (Session::has('instagram')) {
			$data_access = AccessTokenModel::where('value','=',Session::get('instagram')['access_token'])->get();

			$query->where('user_id','=',$data_access[0]->id);
		}

		if (Session::has('facebook')) {
			$data_access = AccessTokenModel::where('value','=',Session::get('facebook')->token)->get();

			$query->where('user_id','=',$data_access[0]->id);
		}

		$data['sosmed'] = $query->get();

		return view('history', compact('data'));

		// return $data;
	}
}
