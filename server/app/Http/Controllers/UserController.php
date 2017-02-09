<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUser()
    {
        return \Auth::user();
    }

    public function getBooks()
    {
        return $this->user->notFinishedBooks();
    }

	public function getRankings()
	{
        return $this->user->whereHas('roles',function($query){
            $query->where("name","admin");
		},'<','1')->orderBy('points','DESC')->get();
    }

    public function postUpdateProfile(Request $request)
    {
        $user = $this->user ;

        $this->validate($request, [

            'lastName'  => 'required|max:255',
            'firstName' => 'required|max:255',
            'email'     => 'required|email|max:255|unique:users,id,'.$this->user->id,
            'address'             => '' ,
            'hours'   => 'integer|min:0',
            'minutes'   => 'integer|min:0'

        ]);

        $user->firstName = $request->get("firstName");
        $user->lastName = $request->get("lastName");
        $user->email = $request->get("email");
        $user->address = $request->get("address");

        if ($request->get('minutes')>59 || $request->get('minutes')<0) {
            return $this->error([
                "minutes" => ["Campul pentru minute trebuie sa fie valid ."] ,
            ]);
        }

        if ($request->get('hours')<0) {
            return $this->error([
                "hours" => ["Campul pentru ore trebuie sa fie valid ."] ,
            ]);
        }

        $user->minutesForReading = $request->get('hours')*60 + $request->get('minutes');

        $user->save();

    }



}
