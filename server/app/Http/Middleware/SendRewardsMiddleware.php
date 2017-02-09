<?php

namespace App\Http\Middleware;

use App\Mail\Reward;
use App\Models\Competition;
use Closure;
use Illuminate\Support\Facades\Mail;

class SendRewardsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$user = \Auth::user();

	    $competition = Competition::last()->first();

	    if($competition && !$competition->finished){
	        // give rewards

		    $competition = $competition->with(["participants" => function($query){
			    $query->orderBy('correct_quiz_answers',"DESC");
		    }])->first();

		    Mail::to($user->email)->send(new Reward());

		    $competition->finished = true;
		    $competition->save();

//		    return redirect()->back();
//		    dd($competition->participants);
	    }

        return $next($request);
    }
}
