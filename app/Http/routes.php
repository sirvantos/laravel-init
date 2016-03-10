<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

get('/', function () {
    return view('app');
});

Route::version(['v1', 'v2'], ['namespace' => 'App\Http\Controllers\Api'], function () {
	Route::resource('movies', 'MoviesController');

	Route::get('movies/auto/complete', ['as' => 'api.auto.complete', 'uses' => 'MoviesController@autoComplete']);
});