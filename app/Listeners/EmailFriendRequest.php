<?php

namespace Medlib\Listeners;

use Medlib\Models\User;
use Medlib\Events\FriendRequestWasSent;
use Medlib\Notifications\SendFriendRequestAlertEmail;

class EmailFriendRequest
{
    /**
     * @var \Medlib\Models\User
     */
    public $user;

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
     * @param \Medlib\Events\FriendRequestWasSent $event
     * @return boolean
     */
    public function handle(FriendRequestWasSent $event)
    {
        $event->requestedUser->notify(new SendFriendRequestAlertEmail($event->requesterUser));
        return true;
    }
}
