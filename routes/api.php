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

    /**
    |--------------------------------------------------------------------------
    | Authentification routes
    |--------------------------------------------------------------------------
     */
    Route::group(['middleware' => 'guest:api', 'namespace' => 'Auth'], function () {
        Route::post('/login', ['uses' => 'AuthController@doLogin', 'as' => 'auth.submit']);
        Route::post('/register', ['uses' => 'AuthController@doRegister', 'as' => 'auth.register.submit']);
        Route::get('/register/verify/{token}', [ 'uses' => 'AuthController@doVerify', 'as' => 'auth.verify' ]);

        Route::get('/auth/{provider}', ['uses' => 'SocialAuthController@redirectToSocialProvider', 'as' => 'auth.social']);
        Route::get('/auth/{provider}/callback', ['uses' => 'SocialAuthController@handleSocialProviderCallback', 'as' => 'auth.social.callback']);

        /**
         * Password reset link request routes...
         */
        Route::post('/password/email', ['uses' => 'ForgotPasswordController@sendResetLinkEmail', 'as' => 'password.post']);

        /**
         * Password reset routes...
         */
        Route::post('/password/reset', ['uses' => 'ResetPasswordController@reset', 'as' => 'password.submit']);
        //Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm');
    });

    /**
    |--------------------------------------------------------------------------
    | Auth middleware routes
    |--------------------------------------------------------------------------
     */
    Route::group(['middleware' => ['auth', 'jwt.auth']], function () {

        /**
        |--------------------------------------------------------------------------
        | Logout routes
        |--------------------------------------------------------------------------
         */
        Route::delete('/logout', ['uses' => 'Auth\AuthController@doLogout','as' => 'auth.logout']);

       // Route::resource('timelines', 'TimelineController',  ['except' => ['create']]);
        /**
        |--------------------------------------------------------------------------
        | Users routes
        |--------------------------------------------------------------------------
         */
        Route::group(['prefix' => 'u'], function () {
            Route::group(['prefix' => '{username}'], function () {
                Route::group(['namespace' => 'Users'], function () {
                    Route::get('/', [ 'uses' => 'UsersController@show', 'as' => 'profile.user.show' ]);
                    Route::post('/', ['uses' => 'UsersController@index', 'as' => 'profile.user.store' ]);
                });

                Route::get('/me', ['uses' => 'Users\UsersController@me', 'as' => 'user.me']);

                Route::group(['namespace' => 'Friends', 'prefix' => 'friends'], function () {
                    Route::get('/', ['uses' => 'FriendController@index', 'as' => 'user.friends.show']);
                    Route::get('/all', ['uses' => 'FriendController@friends', 'as' => 'user.friends.all']);
                });

                Route::group(['namespace' => 'Timelines'], function () {
                    Route::get('/feeds', ['uses' => 'FeedController@index', 'as' => 'user.feeds.show']);
                    Route::post('/feeds', ['uses' => 'FeedController@store', 'as' => 'user.feeds.store']);
                    Route::get('/feeds/more', ['uses' => 'FeedController@more', 'as' => 'user.feeds.more']);
                    Route::post('/feeds/{status_id}/like', ['uses'  => 'FeedController@like', 'as' => 'user.feeds.like']);
                    Route::post('/feeds/{status_id}/unlike', ['uses'  => 'FeedController@unlike', 'as' => 'user.feeds.unlike']);
                    Route::post('/feeds/{status_id}/comment', ['uses'  => 'FeedController@comment', 'as' => 'user.feeds.comment']);
                });
            });
        });

        /**
        |--------------------------------------------------------------------------
        | Friends & Friends-requests routes
        |--------------------------------------------------------------------------
         */
        Route::group(['prefix' => 'friends', 'namespace' => 'Friends'], function () {
            /**
             * Friends
             */
            Route::get('/', ['uses' => 'FriendController@index', 'as' => 'friends.show']);
            Route::post('/', ['uses' => 'FriendController@store', 'as' => 'friends.store']);
            Route::delete('/', ['uses' => 'FriendController@destroy', 'as' => 'friends.del']);
            /**
             * Friend-requests
             */
            Route::get('/requests', ['uses' => 'FriendRequestController@index', 'as' => 'request.show']);
            Route::post('/requests', ['uses' => 'FriendRequestController@store', 'as' => 'request.post']);
            Route::delete('/requests', ['uses' => 'FriendRequestController@destroy', 'as' => 'request.del']);
        });

        /**
        |--------------------------------------------------------------------------
        | Messages routes
        |--------------------------------------------------------------------------
         */
        Route::group(['prefix' => 'messages', 'namespace' => 'Messages'], function () {
            Route::get('/', ['uses' => 'MessageController@index', 'as' => 'message.all']);
            Route::post('/', ['uses' => 'MessageController@store', 'as' => 'message.store']);
            Route::get('/{username}', ['uses' => 'MessageController@show', 'as' => 'message.show'])->where('username', '[a-zA-Z]+');
            Route::get('/compose/{username}', ['uses' => 'MessageController@create', 'as' => 'message.compose']);
            Route::delete('/delete', ['uses' => 'MessageController@destroy', 'as' => 'message.delete']);
        });

        /**
        |--------------------------------------------------------------------------
        | Conversations routes
        |--------------------------------------------------------------------------
         */
        Route::group(['prefix' => 'conversations', 'namespace' => 'Messages'], function(){
            Route::get('/', ['uses' => 'ConversationsController@index', 'as' => 'conversation.all']);
            Route::post('/', ['uses' => 'ConversationsController@store', 'as' => 'conversation.store']);
            Route::get('/{id}', ['uses' => 'ConversationsController@show', 'as' => 'conversation.show']);

        });
    });


    /**
    |--------------------------------------------------------------------------
    | Site routes
    |--------------------------------------------------------------------------
     */
    Route::group(['prefix' => 'site', 'namespace' => 'About'], function () {
        Route::post('contact', ['uses' => 'AboutController@store', 'as' => 'contact.store']);
    });

    /**
    |--------------------------------------------------------------------------
    | Manage Language routes
    |--------------------------------------------------------------------------
     */
    Route::group(['prefix' => 'lang', 'namespace' => 'Lang'], function () {
        Route::any('/{lang}', ['uses' => 'LangController@doLang', 'as' => 'lang']);
    });
});
