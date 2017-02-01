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

Route::group(['middleware' => 'language'], function () {
    //Route::get('/user', ['uses' => 'API\UsersController@index','as' => 'api.user', 'middleware' => ['auth:api','jwt.auth'] ]);
});