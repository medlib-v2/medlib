<?php

namespace Medlib\Events;

use Medlib\Models\User;
use Medlib\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserWasRegistered extends Event
{
    use SerializesModels;

    /**
     * @var Object
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param Object $user
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
