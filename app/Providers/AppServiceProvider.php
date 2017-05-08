<?php

namespace Medlib\Providers;

use Medlib\Services\ProcessImage;
use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\ServiceProvider;
use Medlib\Repositories\User\UserRepository;
use Medlib\Repositories\Feed\FeedRepository;
use Medlib\Repositories\Page\PageRepository;
use Medlib\Repositories\Group\GroupRepository;
use Medlib\Http\Requests\CreateMessageRequest;
use Medlib\Repositories\Message\MessageRepository;
use Medlib\Repositories\Comment\CommentRepository;
use Medlib\Repositories\User\EloquentUserRepository;
use Medlib\Repositories\Feed\EloquentFeedRepository;
use Medlib\Repositories\Page\EloquentPageRepository;
use Medlib\Repositories\Group\EloquentGroupRepository;
use Medlib\Repositories\Comment\EloquentCommentRepository;
use Medlib\Repositories\Message\EloquentMessageRepository;
use Medlib\Repositories\FriendRequest\FriendRequestRepository;
use Medlib\Repositories\FriendRequest\EloquentFriendRequestRepository;

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
        $this->app->bind('ProcessImage', ProcessImage::class);

        $this->app->bind(FeedRepository::class, EloquentFeedRepository::class);

        /**
         * Uncomment if you don't wish to cache all users
         */
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);

        $this->app->bind(FriendRequestRepository::class, EloquentFriendRequestRepository::class);

        $this->app->bind(CommentRepository::class, EloquentCommentRepository::class);
        
        $this->app->bind(MessageRepository::class, EloquentMessageRepository::class);

        $this->app->bind('MessageRequest', CreateMessageRequest::class);

        $this->app->bind(PageRepository::class, EloquentPageRepository::class);

        $this->app->bind(GroupRepository::class, EloquentGroupRepository::class);

        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
}
