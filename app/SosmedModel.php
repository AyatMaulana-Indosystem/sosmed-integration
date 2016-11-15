<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SosmedModel extends Model
{
	protected $table = 'sosmed';
	protected $fillable = ['user_id','post_id','konten','media','waktu','source','link'];
	public $timestamps = FALSE;

	public function access_token(){
		return $this->hasOne('App\AccesTokenModel','user_id');
	}
}
