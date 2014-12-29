<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});


// // Route group for API versioning
// Route::group(array('prefix' => 'api/v1', 'before' => '<span class="skimlinks-unlinked">auth.basic</span>'), function()
// {
//     Route::resource('url', 'UrlController');
// });

Route::pattern('id', '[0-9]+');
Route::api(['version' => 'v1', 'prefix' => 'api'], function () {
    Route::get('users', 'UserController@index');
    Route::get('users/{id}', 'UserController@show');
    Route::post('users/', 'UserController@store');
    Route::put('users/{id}', 'UserController@update');
    Route::delete('users/{id}', 'UserController@destroy');
});
