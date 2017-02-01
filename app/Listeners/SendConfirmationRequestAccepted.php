<?php

namespace Medlib\Listeners;

use Medlib\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Medlib\Events\FriendRequestWasAccepted;
use Medlib\Notifications\SendConfirmationRequestAccepted as ConfirmationRequestAccepted;

class SendConfirmationRequestAccepted
{
    /**
     * @var \Medlib\Models\User
     */
    private $user;

    /**
     * Create the event listener.
     *
     * @param \Medlib\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Handle the event.
     *
     * @param  FriendRequestWasAccepted  $event
     * @return void
     */
    public function handle(FriendRequestWasAccepted $event)
    {
        $event->friend->notify(new ConfirmationRequestAccepted($event->currentUser));
    }
}
