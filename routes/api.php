<?php

use Illuminate\Http\Request;

// get rid of auth middleware for now so axios can fetch data
//
Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/posts', 'PostController@index');
    Route::post('/posts', 'PostController@store');
});
