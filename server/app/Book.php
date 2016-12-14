<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Book extends Model
{
	public $timestamps = false;

	protected $fillable = ['title', 'pages', 'bookmark', 'author', 'description', 'added_at'];

	protected $dates = ['added_at'];

	protected $appends = ['time', 'points'];

	public function getTimeAttribute()
	{
		$user              = Auth::user();
		$nrPages           = $this->pages;
		$minutesForReading = $user->minutesForReading;

		$daysToRead = round(($nrPages / 0.5) / $minutesForReading);

		return $daysToRead;
	}

	public function getPoints()
	{
		$daysToFinish = $this->time;

		$currentTime       = Carbon::now();
		$currentFinishDate = $currentTime->diffInDays($this->added_at);

		$nrPages = $this->pages;
		$points  = $nrPages;

		$bonus = $points / $daysToFinish * ($daysToFinish - $currentFinishDate);

		return [
			'points' => $points,
			'bonus'  => $bonus,
		];
	}

	public function getPointsAttribute()
	{
		return $this->getPoints()['points'];
	}

	public function scopeFinishedBooks()
	{
		return $this->where('finished', 1);
	}

}
