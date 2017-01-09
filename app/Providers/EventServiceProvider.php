<?php

namespace Medlib\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Medlib\Events\UserWasRegistered;
use Medlib\Events\JsonWebTokenExpired;
use Medlib\Listeners\ClearJwtListener;
use Medlib\Listeners\CreateJwtListener;
use Medlib\Events\FriendRequestWasSent;
use Medlib\Listeners\EmailFriendRequest;
use Medlib\Listeners\SendConfirmationEmail;
use Medlib\Events\UserRegistrationConfirmation;
use Medlib\Listeners\EmailRegistrationConfirmation;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserWasRegistered::class            => [ SendConfirmationEmail::class ],
        FriendRequestWasSent::class         => [ EmailFriendRequest::class ],
        UserRegistrationConfirmation::class => [ EmailRegistrationConfirmation::class ],
        JsonWebTokenExpired::class          => [CreateJwtListener::class],
        Login::class                        => [CreateJwtListener::class],
        Logout::class                       => [ClearJwtListener::class],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
