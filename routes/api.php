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

Route::group(['prefix' => 'auth'], function () {
    Route::get('/login', 'AuthController@login')->name('login');

    Route::post('/verify', 'AuthController@verify')->name('auth.verify');

    Route::post('/logout', 'AuthController@logout')->middleware('auth:api');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/users/{user}/repositories', 'RepositoryFetcher@fetchForUser');

    Route::apiResource('/repositories/{repositoryId}/notes', 'NoteController');
});
