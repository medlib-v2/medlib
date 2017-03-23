<?php

/**
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/**
Route::group(['middleware' => 'language'], function () {
    /** Home Page **\/
    Route::get('/', [ 'uses' => 'HomeController@index', 'as' => 'home']);
    Route::get('/404', [ 'uses' => 'Errors\ErrorController@notFoundHttp', 'as' => 'errors.not.found']);

    /**
    |--------------------------------------------------------------------------
    | Authentification routes
    |--------------------------------------------------------------------------
     *\/
    Route::group(['middleware' => 'guest', 'namespace' => 'Auth'], function () {
        Route::get('/login', ['uses' => 'AuthController@showLogin',  'as' => 'auth.login']);
        Route::get('/register', ['uses' => 'AuthController@showRegister', 'as' => 'auth.register']);
        //Route::get('/register/verify/{token}', [ 'uses' => 'AuthController@doVerify', 'as' => 'auth.verify' ]);
        Route::get('/reg_birthday', [ 'uses' => 'AuthController@regBirthday',  'as' => 'auth.reg_birthday' ]);

        /**
         * Password reset routes...
         *\/
        Route::get('/password/reset', ['uses' => 'ForgotPasswordController@showLinkRequestForm', 'as' => 'password.reset']);
        Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm');
    });

    Route::get('/logout', ['uses' => 'Auth\AuthController@doLogout','as' => 'auth.logout', 'middleware' => 'auth' ]);

    /**
    |--------------------------------------------------------------------------
    | Yaz Recherche routes
    |--------------------------------------------------------------------------
     *\/
    Route::group(['prefix' => 'search', 'namespace' => 'Search'], function () {
        Route::get('/simple', ['uses' => 'SearchQueryController@doSimple', 'as' => 'search.simple']);
        Route::get('/advanced', ['uses' => 'SearchQueryController@doAdvanced', 'as' => 'search.advanced']);
        Route::get('/detail', ['uses' => 'SearchQueryController@doDetail', 'as' => 'search.detail']);
    });

    /**
    |--------------------------------------------------------------------------
    | Notifications routes
    |--------------------------------------------------------------------------
     *\/
    Route::group(['prefix' => 'notifications', 'middleware' => ['auth','jwt.auth'], 'namespace' => 'Notifications'], function () {
        Route::get('/', ['uses' => 'NotificationsController@index', 'as' => 'notifications.show']);
        Route::post('/', ['uses' => 'NotificationsController@store', 'as' => 'notifications.store']);
        Route::get('/last', ['uses' => 'NotificationsController@last', 'as' => 'notifications.last']);
        Route::get('/all', ['uses' => 'NotificationsController@notifications', 'as' => 'notifications.all']);
        Route::get('/unread', ['uses' => 'NotificationsController@unread', 'as' => 'notifications.unread']);
        Route::patch('/{id}/read', ['uses' => 'NotificationsController@markAsRead', 'as' => 'notifications.read']);
        Route::post('/mark-all-read', ['uses' => 'NotificationsController@markAllRead', 'as' => 'notifications.read.all']);
        Route::post('/{id}/dismiss', ['uses' => 'NotificationsController@dismiss', 'as' => 'notifications.dismiss']);
    });

    /**
    |--------------------------------------------------------------------------
    | User settings routes
    |--------------------------------------------------------------------------
     *\/
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
        Route::delete('/{username}/delete', [ 'uses' => 'SettingsController@deleteUsername', 'as' => 'profile.delete.username' ]);
    });

    /**
    |--------------------------------------------------------------------------
    | Dashboard routes
    |--------------------------------------------------------------------------
     *\/
    Route::group(['prefix' => 'dashboard', 'middleware' => ['auth','jwt.auth'], 'namespace' => 'Dashboard'], function () {
        Route::get('/', ['uses' => 'DashboardController@index', 'as' => 'dashboard.home']);
        Route::get('/books', ['uses' => 'DashboardController@books', 'as' => 'dashboard.books']);
        Route::get('/history', ['uses' => 'DashboardController@history', 'as' => 'dashboard.history']);
        Route::get('/viewed', ['uses' => 'DashboardController@viewed', 'as' => 'dashboard.viewed']);
        Route::get('/search', ['uses' => 'SearchUserController@getResults', 'as' => 'dashboard.search']);
    });

    /**
    |--------------------------------------------------------------------------
    | Chat routes
    |--------------------------------------------------------------------------
     *\/
    Route::group(['prefix' => 'chat', 'middleware' => ['auth','jwt.auth'], 'namespace' => 'Chat'], function () {
        /** Chat Status **\/
        Route::post('chatstatus', ['uses' => 'ChatController@update', 'as' => 'chat.status', ]);
        /** Chat Message **\/
        Route::get('messages', ['uses' => 'ChatController@messages', 'as' => 'chat.all.conversation', ]);
        Route::post('message', ['uses' => 'ChatController@message', 'as' => 'chat.conversation', ]);
    });

    /**
    |--------------------------------------------------------------------------
    | Helpers routes
    |--------------------------------------------------------------------------
     *\/
    Route::group(['prefix' => 'helpers', 'namespace' => 'Helpers'], function () {
        Route::get('/', ['uses' => 'HelpersController@index', 'as' => 'helpers.home']);
        Route::get('/deleting', ['uses' => 'HelpersController@deletingAccount', 'as' => 'helpers.deleting.account']);
    });

    /**
    |--------------------------------------------------------------------------
    | Manage Language routes
    |--------------------------------------------------------------------------
     *\/
    Route::group(['prefix' => 'lang', 'namespace' => 'Lang'], function () {
        Route::any('/{lang}', ['uses' => 'LangController@doLang', 'as' => 'lang']);
    });

    /**
    |--------------------------------------------------------------------------
    | Site routes
    |--------------------------------------------------------------------------
     *\/
    Route::group(['prefix' => 'site', 'namespace' => 'About'], function () {
        Route::get('about', ['uses' => 'AboutController@index', 'as' => 'contact.index']);
        Route::get('contact', ['uses' => 'AboutController@create', 'as' => 'contact.show']);
        Route::post('contact', ['uses' => 'AboutController@store', 'as' => 'contact.store']);
    });
});
**/

Route::group(['middleware' => 'language'], function () {
    Route::get('{uri?}', [ 'uses' => 'HomeController@index', 'as' => 'home'])->where('uri', '(.*)');
});
