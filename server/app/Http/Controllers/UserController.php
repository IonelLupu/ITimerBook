<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class UserController extends Controller
{
    public function getBooks()
    {
        return Book::all();
    }
}
