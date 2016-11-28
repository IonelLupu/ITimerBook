<?php

namespace App\Http\Controllers\Auth;

use App\User;
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
                    'login' => ['Credentiale invalide']
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
            'firstName' => 'required|max:255',
            'lastName'  => 'required|max:255',
            'email'     => 'required|email|max:255|unique:users',
            'password'  => 'required|min:6|confirmed',
        ]);

        $user = new User($request->all());

        $user->password = Hash::make($user->password);
        $user->save();

        return $this->response($user);
    }
}
