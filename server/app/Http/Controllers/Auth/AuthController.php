<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|max:255',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->error([
                    'login' => ['Email sau Parola gresite .']
                ]);
            }

            return $this->response([
                "user"  => Auth::user(),
                "token" => $token
            ]);

        } catch (JWTException $e) {
            // something went wrong
            return $this->internalError('could_not_create_token');
        }
    }

    public function register(Request $request)
    {
        /***********************************************
         ************ Validation
         **********************************************/
        $this->validate($request, [
            'lastName'  => 'required|max:255',
            'firstName' => 'required|max:255',
            'email'     => 'required|email|max:255|unique:users',
            'password'  => 'required|min:6|confirmed',
        ]);


        $data = $request->all();

        if ($data['hours']==0 && $data['minutes']==0) {
            return $this->error([
                "hours" => ["Campul pentru timpul alocat cititului pe zi este obligatoriu ."] ,
                "minutes" => ["Campul pentru timpul alocat cititului pe zi este obligatoriu ."]
          ]);
        }

        if ($data['minutes']>59 || $data['minutes']<0) {
            return $this->error([
                "minutes" => ["Campul pentru minute trebuie sa fie valid ."] ,
                ]);
        }

        if ($data['hours']<0) {
            return $this->error([
                "hours" => ["Campul pentru ore trebuie sa fie valid ."] ,
            ]);
        }

        $data['minutesForReading'] = $data['hours']*60 + $data['minutes'];

        $user = new User($data);
        $user->password = Hash::make($user->password);
        $user->save();

        $categories = array_keys($request->get('categories'));
        $user->categories()->attach($categories);

        return $this->response($user);
    }
}
