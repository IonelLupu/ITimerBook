<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function postBook(Request $request)
    {
        $this->validate($request, [
            'title'       => 'required',
            'pages'       => 'required|integer',
            'author'      => '',
            'description' => '',
        ]);


        $user=Auth::user();
        $book = new Book($request->all());
        $book->user_id = $user->id;
        $book->save();

//        $user = Auth::user();
//        $book = new Book($request->all());
//        $user->books()->save($book);
    }
}
