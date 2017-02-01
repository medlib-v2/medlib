<?php

namespace Medlib\Events;

use Medlib\Models\User;
use Medlib\Events\Event;
use Illuminate\Queue\SerializesModels;

class FriendRequestWasAccepted extends Event
{
    use SerializesModels;

    /**
     * @var \Medlib\Models\User
     */
    public $currentUser;

    /**
     * @var \Medlib\Models\User
     */
    public $friend;

    /**
     * Create a new event instance.
     *
     * @param \Medlib\Models\User $currentUser
     * @param \Medlib\Models\User $friend
     */
    public function __construct(User $currentUser, User $friend)
    {
        $this->currentUser = $currentUser;
        $this->friend = $friend;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
