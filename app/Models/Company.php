<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends \App\Models\Base\Company
{
	protected $fillable = [
		'name',
		'email',
		'prefecture_id',
		'phone',
		'postcode',
		'city',
		'local',
		'street_address',
		'business_hour',
		'regular_holiday',
		'image',
		'fax',
		'url',
		'license_number'
	];

	public function prefectures(){
		return $this->belongsTo('App\Models\Prefecture', 'id', 'prefecture_id');
	}
}
