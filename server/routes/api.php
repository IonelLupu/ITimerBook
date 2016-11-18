<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/getBooks', function () {
  $books = [
    [
      "id" => 1,
      "title" => "Scrisoara a II-a",
    ],
    [
      "id" => 2,
      "title" => "Ursul pacalit de vulpe",
    ],
    [
      "id" => 3,
      "title" => "Pacala",
    ],
  ];

  return $books;
})->middleware(['api','cors']);
