<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Prefecture extends \App\Models\Base\Prefecture
{
	protected $fillable = [
		
		'name',
		'display_name',
		'area_id'
	];

	public function companies()
    {
        return $this->hasMany('App\Models\Company', 'prefecture_id', 'id');
    }
	

}
