<?php

namespace Medlib\Providers;

use Medlib\Events\UserWasRegistered;
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
        UserWasRegistered::class => [ SendConfirmationEmail::class ],
        FriendRequestWasSent::class => [ EmailFriendRequest::class ],
        UserRegistrationConfirmation::class => [ EmailRegistrationConfirmation::class ],
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
