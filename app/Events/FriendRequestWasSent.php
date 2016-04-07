<?php

namespace Medlib\Events;

use Medlib\Models\User;
use Medlib\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class FriendRequestWasSent extends Event {

    use SerializesModels;

    /**
     * @var \Medlib\Models\User
     */
    public $requestedUser;

    /**
     * @var \Medlib\Models\User
     */
    public $requesterUser;

    /**
     * Create a new event instance.
     *
     * @param \Medlib\Models\User $requestedUser
     * @param \Medlib\Models\User $requesterUser
     */
    public function __construct(User $requestedUser, User $requesterUser) {

        $this->requestedUser = $requestedUser;
        $this->requesterUser = $requesterUser;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn() {
        return [];
    }
}
