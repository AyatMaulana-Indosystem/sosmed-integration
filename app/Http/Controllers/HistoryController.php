<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AccessTokenModel;
use App\SosmedModel;

use Session;

class HistoryController extends Controller
{
	public function index(){
		$data_access = AccessTokenModel::where('value','=',Session::get('instagram')['access_token'])->get();

		$data['instagram'] = SosmedModel::where('user_id','=',$data_access[0]->id)->orderBy('waktu','DESC')->get();
		return view('history', compact('data'));
	}
}
