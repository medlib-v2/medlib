<?php

namespace Medlib\Providers;

use Medlib\Events\UserWasRegistered;
use Medlib\Events\EmailFriendRequest;
use Medlib\Events\FriendRequestWasSent;
use Medlib\Events\SendConfirmationEmail;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider {
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        //'Medlib\Events\SomeEvent' => [ 'Medlib\Listeners\EventListener',],
        UserWasRegistered::class => [ SendConfirmationEmail::class ],
        FriendRequestWasSent::class => [ EmailFriendRequest::class ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events) {
        parent::boot($events);

        //
    }
}
