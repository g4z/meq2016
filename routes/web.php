<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::get('/', function () {
    return view('dashboard', [
        'language' => App::getLocale(),
        'rate' => config('meq2016.update.rate'),
    ]);
});

Route::group(['prefix' => 'api/v1'], function () {
    Route::get('latest', ['uses' => 'ApiController@getLatestEvents']);
});

