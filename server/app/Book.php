<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Book extends Model
{
	public $timestamps = false;

	protected $fillable = ['title', 'pages', 'bookmark', 'author', 'description', 'added_at'];

	protected $dates = ['added_at'];

	protected $appends = ['time', 'points', 'supposedProgressPercent', 'supposedProgressPages','remainingDays'];

	public function getTimeAttribute()
	{
		$user              = Auth::user();
		$nrPages           = $this->pages;
		$minutesForReading = $user->minutesForReading;

		$daysToRead = ceil(($nrPages / 0.5) / $minutesForReading);

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

	public function getSupposedProgressPercentAttribute()
	{
		$currentTime = Carbon::now();
		$added_at    = $this->added_at;

		return ($currentTime->diffInDays($added_at)) / $this->time * 100;
	}

	public function getSupposedProgressPagesAttribute()
	{
		return intval($this->supposedProgressPercent / 100 * $this->pages);
	}

	public function getRemainingDaysAttribute()
	{
		$currentTime = Carbon::now();

		$finishDate = $this->added_at->addDays($this->time);

		return $finishDate->diffInDays($currentTime);
	}
}
