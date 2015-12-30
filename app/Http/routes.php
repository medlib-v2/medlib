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

use Carbon\Carbon;
use Medlib\Models\User;
use Illuminate\Support\Facades\Mail;


/**
 * Home Page
 */
Route::get('/', [ 'uses' => 'HomeController@index', 'as' => 'home']);

Route::get('/newuser', function(){


    $user = User::where('username', '=', 'djandone')->first();

    $account = [
        'first_name' => $user->first_name,
        'last_name' => $user->last_name,
        'user_avatar' => $user->getAvatar(),
        'confirmation_code' => $user->confirmation_code
    ];
    $token = $user->confirmation_code;

    return view('auth.reminder', compact('token'));
    /**
    Mail::queue('auth.email.verify', compact('account'), function($message) use ($user){
        $message->to($user->email, $user->first_name."".$user->last_name)
            ->subject('Activate your account');
    });
    return "Message sending";
     */

});

/**
 * Friends & Friends-requests
 */
Route::group(['prefix' => 'friends', 'middleware' => 'auth', 'namespace' => 'Friends'], function(){

    /**
     * Friends
     */
    Route::get('/', ['as' => 'friends.show', 'uses' => 'FriendController@index']);

    Route::post('/', ['as' => 'friends.store', 'uses' => 'FriendController@store']);

    Route::delete('/', ['as' => 'friends.del', 'uses' => 'FriendController@destroy']);

    /**
     * Friend-requests
     */
    Route::get('requests', ['as' => 'request.show', 'uses' => 'FriendRequestController@index']);

    Route::post('requests', ['as' => 'request.post', 'uses' => 'FriendRequestController@store']);

    Route::delete('requests', ['as' => 'request.del', 'uses' => 'FriendRequestController@destroy']);
});



/**
 * Messages & Messages-Responses
 */
Route::group(['prefix' => 'messages', 'middleware' => 'auth', 'namespace' => 'Messages'], function(){
    /**
     * Messages
     */
    Route::get('/', ['as' => 'message.all', 'uses' => 'MessageController@index']);

    Route::post('/', ['as' => 'message.store', 'uses' => 'MessageController@store']);

    Route::get('/{username}', ['as' => 'message.show', 'uses' => 'MessageController@show'])->where('username', '[a-zA-Z]+');

    Route::get('/compose/{username}', ['as' => 'message.compose', 'uses' => 'MessageController@create']);

    Route::delete('delete', ['as' => 'message.delete', 'uses' => 'MessageController@destroy']);

    /**
     * MessageResponses
     */
    Route::put('response', ['as' => 'message.response', 'uses' => 'MessageResponseController@update']);

    Route::post('response', ['as' => 'message.response', 'uses' => 'MessageResponseController@store']);

});


/**
 * Authentification
 */
Route::group(['middleware' => 'guest', 'namespace' => 'Auth'], function(){
    Route::get('/login', ['uses' => 'AuthController@showLogin',  'as' => 'auth.login']);

    Route::post('/login', ['uses' => 'AuthController@doLogin']);

    Route::get('/register', ['uses' => 'AuthController@showRegister', 'as' => 'auth.register']);

    Route::post('/register', ['uses' => 'AuthController@doRegister']);

    Route::get('/register/verify/{confirmation_code}', [ 'uses' => 'AuthController@doVerify', 'as' => 'auth.verify' ]);

    Route::get('/reg_birthday', [ 'uses' => 'Auth\AuthController@reg_birthday',  'as' => 'auth.reg_birthday' ]);

    // Password reset link request routes...
    Route::get('/password/email', 'PasswordController@getEmail');
    Route::post('/password/email', 'PasswordController@postEmail');

    // Password reset routes...
    Route::get('/password/reset/{token}', 'PasswordController@getReset');
    Route::post('/password/reset', 'PasswordController@postReset');
});
Route::get('/logout', ['uses' => 'Auth\AuthController@doLogout','as' => 'auth.logout', 'middleware' => 'auth' ]);

/**
 * Recherche with yaz
 */
Route::group(['prefix' => 'search', 'namespace' => 'Search'], function(){

    Route::get('/simple', ['uses' => 'SearchQueryController@doSimple', 'as' => 'search.simple']);

    Route::get('/advanced', ['uses' => 'SearchQueryController@doAdvanced', 'as' => 'search.advanced']);
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

    Route::get('/{username}', [ 'uses' => 'UsersController@show', 'as' => 'profile.user.show' ]);

    Route::post('/', [ 'uses' => 'UsersController@index', 'as' => 'profile.user.show' ]);

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

    Route::get('/', ['uses' => 'DashboardController@index', 'as' => 'dashboard.home']);

    Route::get('/books', ['uses' => 'DashboardController@books', 'as' => 'dashboard.books']);

    Route::get('/history', ['uses' => 'DashboardController@history', 'as' => 'dashboard.history']);

    Route::get('/viewed', ['uses' => 'DashboardController@viewed', 'as' => 'dashboard.viewed']);

    Route::get('/search', ['uses' => 'SearchUserController@getResults', 'as' => 'dashboard.search']);
});

/**
 * Helpers
 */
Route::group(['prefix' => 'helpers', 'namespace' => 'Helpers'], function(){

    Route::get('/', ['uses' => 'DashboardController@index', 'as' => 'helpers.home']);

    Route::get('/deleting', ['uses' => 'HelpersController@deletingAccount', 'as' => 'helpers.deleting.account']);
});