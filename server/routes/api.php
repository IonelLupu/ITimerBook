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

Route::group(['middleware' => ['cors']], function () {

    // public routes
    Route::post('register','Auth\AuthController@register');
    Route::post('auth','Auth\AuthController@authenticate');
    Route::get('categories','Controller@getCategories');


    // private routes
    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::get('user','UserController@getUser');
        Route::get('books','UserController@getBooks');
        Route::post('addBook','BookController@postBook');
        Route::post('finish','BookController@postFinishBook');
        Route::post('updatePages','BookController@postUpdatePages');
        Route::post('deleteBook','BookController@postDelete');
        Route::post('updateProfile','UserController@postUpdateProfile');

        Route::get('questions','CompetitionController@getQuestions');
        Route::post('answers','CompetitionController@postAnswers');

        Route::get('profile','UserController@postUpdateProfile');
        Route::get('history','BookController@getHistory');
        Route::get('rankings','UserController@getRankings');

    });

});