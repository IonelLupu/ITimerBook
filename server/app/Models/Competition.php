<?php

namespace App\Models;

use JCWolf\DataModeler\Model;
use Carbon\Carbon;

class Competition extends Model
{

	public $timestamps = false;

	protected $appends = ['points'];

	public function participants()
	{
		return $this->hasMany(Participant::class);
	}

	public function getPointsAttribute()
	{
		return $this->bookToRead_pages;
	}

	public function scopeCurrent($query)
	{
		return $query
			->where(function ($query) {
				$query->where('starts_at', '<=', Carbon::now());
				$query->where('ends_at', '>=', Carbon::now());
			})
			->orderBy('ends_at','DESC');
	}
}
