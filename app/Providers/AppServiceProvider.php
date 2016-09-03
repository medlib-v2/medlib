<?php

namespace Medlib\Providers;

use Medlib\Services\ProcessImage;
use Medlib\Services\EmailNotifier;
use Collective\Bus\BusServiceProvider;
use Medlib\Services\EmailNotifierInterface;
use Medlib\Repositories\Comment\CommentRepository;
use Medlib\Repositories\Comment\EloquentCommentRepository;
use Medlib\Repositories\FriendRequest\FriendRequestRepository;
use Medlib\Repositories\FriendRequest\EloquentFriendRequestRepository;
use Medlib\Repositories\User\UserRepository;
use Medlib\Repositories\User\EloquentUserRepository;
use Medlib\Repositories\Message\MessageRepository;
use Medlib\Repositories\Message\EloquentMessageRepository;
use Medlib\Repositories\Feed\FeedRepository;
use Medlib\Repositories\Feed\EloquentFeedRepository;

use Medlib\Http\Requests\CreateMessageRequest;
use Medlib\Http\Requests\CreateMessageResponseRequest;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {

        $this->app->bind('ProcessImage', ProcessImage::class);

        $this->app->bind( FeedRepository::class, EloquentFeedRepository::class);

        //Uncomment if you don't wish to cache all users
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);

        $this->app->bind(FriendRequestRepository::class, EloquentFriendRequestRepository::class);

        $this->app->bind(CommentRepository::class, EloquentCommentRepository::class);
        
        $this->app->bind(MessageRepository::class, EloquentMessageRepository::class);

        $this->app->bind('MessageRequest',  CreateMessageRequest::class);

        $this->app->bind('MessageResponseRequest', CreateMessageResponseRequest::class);

        $this->app->bind(EmailNotifierInterface::class, EmailNotifier::class);
    }
}
