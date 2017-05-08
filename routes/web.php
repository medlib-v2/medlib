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
    Route::get('/{uri?}', [ 'uses' => 'HomeController@index', 'as' => 'home'])->where('uri', '(.*)');
    /**
    |--------------------------------------------------------------------------
    | Authentification routes
    |--------------------------------------------------------------------------
    |
    | Password reset routes...
     */
    Route::get('/password/reset/{token}', ['uses' => 'Auth\ForgotPasswordController@showLinkRequestForm', 'as' => 'password.reset']);
});
