<?php

namespace Medlib\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'ProcessImage',
            'Medlib\Services\ProcessImage'
        );

        $this->app->bind(
            'Medlib\Repositories\Feed\FeedRepository',
            'Medlib\Repositories\Feed\EloquentFeedRepository'
        );

        //Uncomment if you don't wish to cache all users
        $this->app->bind(
            'Medlib\Repositories\User\UserRepository',
            'Medlib\Repositories\User\EloquentUserRepository'
        );

        $this->app->bind(
            'Medlib\Repositories\FriendRequest\FriendRequestRepository',
            'Medlib\Repositories\FriendRequest\EloquentFriendRequestRepository'
        );

        $this->app->bind(
            'Medlib\Repositories\Message\MessageRepository',
            'Medlib\Repositories\Message\EloquentMessageRepository'
        );

        $this->app->bind(
            'MessageRequest',
            'Medlib\Http\Requests\CreateMessageRequest'
        );

        $this->app->bind(
            'MessageResponseRequest',
            'Medlib\Http\Requests\CreateMessageResponseRequest'
        );
    }
}
