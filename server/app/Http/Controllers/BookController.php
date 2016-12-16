<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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

//		$user          = Auth::user();
//		$book          = new Book($request->all());
//		$book->user_id = $user->id;
//		$book->save();

        $data = $request->all();

        if ($data['pages']<0 || $data['pages']==0) {
            return $this->error([
                "pages" => ["Campul Numar pagini trebuie sa fie valid ."] ,
            ]);
        }

		$book           = new Book($request->all());
		$book->added_at = Carbon::now();
		$this->user->books()->save($book);

	}

	public function postUpdatePages(Request $request)
	{
		$this->validate($request, [

			'bookmark' => 'required|integer|min:0'

		]);

		$book           = Book::find($request->get("id"));
		$book->bookmark = $request->get("bookmark");

		if ($book->bookmark >= $book->pages) {
			$book->bookmark = $book->pages;
		}
		$book->save();
		return $book->bookmark;
	}


	public function postFinishBook(Request $request)
	{
		// update `finished` flag from database table
		$id = $request->get('id');

		$book = Book::find($id);

		$book->finished = true;
		$book->save();

		// delete book from status (done by the client)

		// update puncte
		$this->user->points += $book->getPoints()['points'] + $book->getPoints()['bonus'];

		$this->user->save();

		return $this->response($book->getPoints());
	}

	public function postDelete(Request $request)
	{
		$book = Book::find($request->get('id'));
		if ($book)
			$book->delete();
	}

	public function getHistory()
	{
		return $this->user->books()->finishedBooks()->orderBy('added_at','DESC')->get();
	}
}

