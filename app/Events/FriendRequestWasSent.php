<?php

namespace Medlib\Events;

use Medlib\Models\User;
use Medlib\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class FriendRequestWasSent extends Event
{
    use SerializesModels;

    /**
     * @var User
     */
    public $requestedUser;

    /**
     * @var User
     */
    public $requesterUser;

    /**
     * Create a new event instance.
     *
     * @param User $requestedUser
     *
     * @param User $requesterUser
     *
     * @return void
     */
    public function __construct(User $requestedUser, User $requesterUser)
    {
        $this->requestedUser = $requestedUser;

        $this->requesterUser = $requesterUser;
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
