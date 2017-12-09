<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{

	protected $fillable = [
		'name',
		'lat',
		'lng',
		'temperature',
		'humidity',
		'wind',
		'radiation',
		'icon'
	];

    public function user() {
    	return $this->hasMany('App\User');
    }
}
