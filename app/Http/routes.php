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

/**
 * Home Page
 */
Route::get('/', [
    'uses' => 'HomeController@index',
    'as' => 'home',
]);

/**
 * Authentification
 */

Route::get('/login', [ 'uses' => 'Auth\AuthController@showLogin',  'as' => 'auth.login',  'middleware' => ['guest'] ]);

Route::post('/login', [ 'uses' => 'Auth\AuthController@doLogin', 'middleware' => ['guest'] ]);

Route::get('/register', [ 'uses' => 'Auth\AuthController@showRegister', 'as' => 'auth.register', 'middleware' => ['guest'] ]);

Route::post('/register', [ 'uses' => 'Auth\AuthController@doRegister', 'middleware' => ['guest'] ]);

Route::get('/register/verify/{confirmation_code}', [ 'uses' => 'Auth\AuthController@doVerify', 'as' => 'auth.verify', 'middleware' => ['guest'] ]);

Route::get('/reg_birthday', [ 'uses' => 'Auth\AuthController@reg_birthday',  'as' => 'auth.reg_birthday' ]);

Route::get('/logout', ['uses' => 'Auth\AuthController@doLogout', 'middleware' => 'auth', 'as' => 'auth.logout']);

/**
 * Recherche with yaz
 */
Route::group(['prefix' => 'search', 'namespace' => 'Search'], function(){

    Route::get('/simple', [
        'uses' => 'SearchQueryController@doSimple',
        'as' => 'search.simple'
    ]);

    Route::get('/advanced', [
        'uses' => 'SearchQueryController@doAdvanced',
        'as' => 'search.advanced'
    ]);
});

/**
 * User settings
 */
Route::group(['prefix' => 'settings', 'middleware' => 'auth', 'namespace' => 'Users'], function() {

    Route::get('/profile', [ 'uses' => 'SettingsController@showProfile', 'as' => 'profile.show.settings' ]);

    Route::post('/profile', [ 'uses' => 'SettingsController@editProfile', 'as' => 'profile.edit.settings' ]);

    Route::get('/admin', [ 'uses' => 'SettingsController@showAdmin', 'as' => 'profile.show.admin' ]);

    Route::post('/admin', [ 'uses' => 'SettingsController@editAdmin', 'as' => 'profile.edit.admin' ]);

    Route::get('/email', [ 'uses' => 'SettingsController@showEmail', 'as' => 'profile.show.email' ]);

    Route::post('/email', [ 'uses' => 'SettingsController@editEmail', 'as' => 'profile.edit.email' ]);

    Route::post('/avatar', [ 'uses' => 'SettingsController@editAvatar', 'as' => 'profile.edit.avatar' ]);

    Route::post('/password', [ 'uses' => 'SettingsController@editPassword', 'as' => 'profile.edit.password' ]);

    Route::post('/username', [ 'uses' => 'SettingsController@editUsername', 'as' => 'profile.edit.username' ]);

    Route::post('/{username}/delete', [ 'uses' => 'SettingsController@deleteUsername', 'as' => 'profile.delete.username' ]);
});

/**
 * Users
 */
Route::group(['prefix' => 'users', 'middleware' => 'auth', 'namespace' => 'Users'], function() {

    Route::get('/', [ 'uses' => 'UsersController@index', 'as' => 'profile.show' ]);

});

/**
 * User settings
 */

Route::group(['prefix' => 'settings', 'middleware' => 'auth', 'namespace' => 'Users'], function() {

    Route::get('/profile', [ 'uses' => 'SettingsController@showProfile', 'as' => 'profile.show.settings' ]);

    Route::post('/profile', [ 'uses' => 'SettingsController@editProfile', 'as' => 'profile.edit.settings' ]);

    Route::get('/admin', [ 'uses' => 'SettingsController@showAdmin', 'as' => 'profile.show.admin' ]);

    Route::post('/admin', [ 'uses' => 'SettingsController@editAdmin', 'as' => 'profile.edit.admin' ]);

    Route::get('/email', [ 'uses' => 'SettingsController@showEmail', 'as' => 'profile.show.email' ]);

    Route::post('/email', [ 'uses' => 'SettingsController@editEmail', 'as' => 'profile.edit.email' ]);

    Route::post('/avatar', [ 'uses' => 'SettingsController@editAvatar', 'as' => 'profile.edit.avatar' ]);

    Route::post('/password', [ 'uses' => 'SettingsController@editPassword', 'as' => 'profile.edit.password' ]);

    Route::post('/username', [ 'uses' => 'SettingsController@editUsername', 'as' => 'profile.edit.username' ]);

    Route::post('/{username}/delete', [ 'uses' => 'SettingsController@deleteUsername', 'as' => 'profile.delete.username' ]);
});

/**
 * Dashboard
 */
Route::group(['prefix' => 'dashboard', 'middleware' => 'auth', 'namespace' => 'Dashboard'], function(){

    Route::get('/', [
        'uses' => 'DashboardController@index',
        'as' => 'dashboard.home'
    ]);

    Route::get('/books', [
        'uses' => 'DashboardController@books',
        'as' => 'dashboard.books'
    ]);

    Route::get('/history', [
        'uses' => 'DashboardController@history',
        'as' => 'dashboard.history'
    ]);

    Route::get('/viewed', [
        'uses' => 'DashboardController@viewed',
        'as' => 'dashboard.viewed'
    ]);

    Route::get('/search', [
        'uses' => 'SearchUserController@getResults',
        'as' => 'dashboard.search'
    ]);
});


/**
 * Helpers
 */
Route::group(['prefix' => 'helpers', 'namespace' => 'Helpers'], function(){

    Route::get('/', [
        'uses' => 'DashboardController@index',
        'as' => 'helpers.home'
    ]);

    Route::get('/deleting', [
        'uses' => 'HelpersController@deletingAccount',
        'as' => 'helpers.deleting.account'
    ]);
});