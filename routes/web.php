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

Route::group(['middleware' => 'language'], function () {
    /** Home Page **/
    Route::get('/', [ 'uses' => 'HomeController@index', 'as' => 'home']);

    Route::get('/404', [ 'uses' => 'Errors\ErrorController@notFoundHttp', 'as' => 'errors.not.found']);

    /** Authentification **/
    Route::group(['middleware' => 'guest', 'namespace' => 'Auth'], function () {
        Route::get('/login', ['uses' => 'AuthController@showLogin',  'as' => 'auth.login']);
        Route::post('/login', ['uses' => 'AuthController@doLogin', 'as' => 'auth.submit']);
        Route::get('/register', ['uses' => 'AuthController@showRegister', 'as' => 'auth.register']);
        Route::post('/register', ['uses' => 'AuthController@doRegister', 'as' => 'auth.register.submit']);
        Route::get('/register/verify/{token}', [ 'uses' => 'AuthController@doVerify', 'as' => 'auth.verify' ]);
        Route::get('/reg_birthday', [ 'uses' => 'AuthController@regBirthday',  'as' => 'auth.reg_birthday' ]);

        Route::get('/auth/{provider}', ['uses' => 'SocialAuthController@redirectToSocialProvider', 'as' => 'auth.social']);
        Route::get('/auth/{provider}/callback', ['uses' => 'SocialAuthController@handleSocialProviderCallback', 'as' => 'auth.social.callback',]);

        /**
         * Password reset link request routes...
         */
        Route::post('/password/email', ['uses' => 'ForgotPasswordController@sendResetLinkEmail', 'as' => 'password.post']);

        /**
         * Password reset routes...
         */
        Route::get('/password/reset', ['uses' => 'ForgotPasswordController@showLinkRequestForm', 'as' => 'password.reset']);
        Route::post('/password/reset', ['uses' => 'ResetPasswordController@reset', 'as' => 'password.submit']);
        Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm');
    });

    Route::get('/logout', ['uses' => 'Auth\AuthController@doLogout','as' => 'auth.logout', 'middleware' => 'auth' ]);

    /** Recherche with yaz **/
    Route::group(['prefix' => 'search', 'namespace' => 'Search'], function () {
        Route::get('/simple', ['uses' => 'SearchQueryController@doSimple', 'as' => 'search.simple']);
        Route::get('/advanced', ['uses' => 'SearchQueryController@doAdvanced', 'as' => 'search.advanced']);
        Route::get('/detail', ['uses' => 'SearchQueryController@doDetail', 'as' => 'search.detail']);
    });

    /** Users */
    Route::group(['prefix' => 'u', 'middleware' => ['auth','jwt.auth']], function () {
        Route::group(['prefix' => '{username}'], function () {

            Route::get('/me', ['uses' => 'Users\UsersController@me', 'as' => 'user.me' ]);

            Route::group(['namespace' => 'Users'], function () {
                Route::get('/', [ 'uses' => 'UsersController@show', 'as' => 'profile.user.show' ]);
                Route::post('/', ['uses' => 'UsersController@index', 'as' => 'profile.user.store' ]);
            });

            Route::group(['namespace' => 'Friends', 'prefix' => 'friends'], function () {
                Route::get('/', ['uses' => 'FriendController@index', 'as' => 'user.friends.show']);
                Route::get('/all', ['uses' => 'FriendController@friends', 'as' => 'user.friends.all']);
            });

            Route::group(['namespace' => 'Feeds'], function () {
                Route::get('/feeds', ['uses' => 'FeedController@index', 'as' => 'user.feeds.show']);
                Route::post('/feeds', ['uses' => 'FeedController@store', 'as' => 'user.feeds.store']);
                Route::get('/feeds/more', ['uses' => 'FeedController@more', 'as' => 'user.feeds.more']);
                Route::get('/feeds/{status_id}/like', ['uses'  => 'FeedController@like', 'as' => 'user.feeds.like']);
                Route::get('/feeds/{status_id}/unlike', ['uses'  => 'FeedController@unlike', 'as' => 'user.feeds.unlike']);
                Route::post('/feeds/{status_id}/comment', ['uses'  => 'FeedController@comment', 'as' => 'user.feeds.comment']);
            });
        });
    });

    /** notifications */
    Route::group(['prefix' => 'notifications', 'middleware' => ['auth','jwt.auth']], function () {

        Route::get('unread', function(){ return Auth::user()->unreadNotifications; });
    });

    /** Friends & Friends-requests **/
    Route::group(['prefix' => 'friends', 'middleware' => ['auth','jwt.auth'], 'namespace' => 'Friends'], function () {
        /** Friends */
        Route::get('/', ['uses' => 'FriendController@index', 'as' => 'friends.show']);
        Route::post('/', ['uses' => 'FriendController@store', 'as' => 'friends.store']);
        Route::delete('/', ['uses' => 'FriendController@destroy', 'as' => 'friends.del']);
        /** Friend-requests */
        Route::get('/requests', ['uses' => 'FriendRequestController@index', 'as' => 'request.show']);
        Route::post('/requests', ['uses' => 'FriendRequestController@store', 'as' => 'request.post']);
        Route::delete('/requests', ['uses' => 'FriendRequestController@destroy', 'as' => 'request.del']);
    });

    /** Messages & Messages-Responses **/
    Route::group(['prefix' => 'messages', 'middleware' => ['auth','jwt.auth'], 'namespace' => 'Messages'], function () {
        /**
         * Messages
         */
        Route::get('/', ['uses' => 'MessageController@index', 'as' => 'message.all']);
        Route::post('/', ['uses' => 'MessageController@store', 'as' => 'message.store']);
        Route::get('/{username}', ['uses' => 'MessageController@show', 'as' => 'message.show'])->where('username', '[a-zA-Z]+');
        Route::get('/compose/{username}', ['uses' => 'MessageController@create', 'as' => 'message.compose']);
        Route::delete('/delete', ['uses' => 'MessageController@destroy', 'as' => 'message.delete']);

        /**
         * MessageResponses
         */
        Route::put('/response', ['uses' => 'MessageResponseController@update', 'as' => 'message.response']);
        Route::post('/response', ['uses' => 'MessageResponseController@store', 'as' => 'message.response']);
    });

    /** User settings **/
    Route::group(['prefix' => 'settings', 'middleware' => ['auth','jwt.auth'], 'namespace' => 'Users'], function () {
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

    /** User settings **/
    Route::group(['prefix' => 'settings', 'middleware' => ['auth','jwt.auth'], 'namespace' => 'Users'], function () {
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

    /** Dashboard **/
    Route::group(['prefix' => 'dashboard', 'middleware' => ['auth','jwt.auth'], 'namespace' => 'Dashboard'], function () {
        Route::get('/', ['uses' => 'DashboardController@index', 'as' => 'dashboard.home']);
        Route::get('/books', ['uses' => 'DashboardController@books', 'as' => 'dashboard.books']);
        Route::get('/history', ['uses' => 'DashboardController@history', 'as' => 'dashboard.history']);
        Route::get('/viewed', ['uses' => 'DashboardController@viewed', 'as' => 'dashboard.viewed']);
        Route::get('/search', ['uses' => 'SearchUserController@getResults', 'as' => 'dashboard.search']);
    });

    /** Chat **/
    Route::group(['prefix' => 'chat', 'middleware' => ['auth','jwt.auth'], 'namespace' => 'Chat'], function () {
        /** Chat Status **/
        Route::post('chatstatus', ['uses' => 'ChatController@update', 'as' => 'chat.status', ]);
        /** Chat Message **/
        Route::post('message', ['uses' => 'ChatController@message', 'as' => 'chat.conversation', ]);
    });

    /** Helpers **/
    Route::group(['prefix' => 'helpers', 'namespace' => 'Helpers'], function () {
        Route::get('/', ['uses' => 'HelpersController@index', 'as' => 'helpers.home']);
        Route::get('/deleting', ['uses' => 'HelpersController@deletingAccount', 'as' => 'helpers.deleting.account']);
    });

    /** Manage Language **/
    Route::group(['prefix' => 'lang', 'namespace' => 'Lang'], function () {
        Route::any('/{lang}', ['uses' => 'LangController@doLang', 'as' => 'lang']);
    });

    /** About **/
    Route::group(['prefix' => 'site', 'namespace' => 'About'], function () {
        Route::get('about', ['uses' => 'AboutController@index', 'as' => 'contact.index']);
        Route::get('contact', ['uses' => 'AboutController@create', 'as' => 'contact.show']);
        Route::post('contact', ['uses' => 'AboutController@store', 'as' => 'contact.store']);
    });
});
