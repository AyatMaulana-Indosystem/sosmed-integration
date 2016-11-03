<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessTokenModel extends Model
{
	protected $table = 'access_token';
	protected $fillable = ['type','value'];

	public function sosmed(){
		return $this->belongsTo('App\SosmedModel','id');
	}
}
