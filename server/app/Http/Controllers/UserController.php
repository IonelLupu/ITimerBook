<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class UserController extends Controller
{
    public function getUser()
    {
        return \Auth::user();
    }

    public function getBooks()
    {
        return $this->response( $this->user->books );
    }


}
