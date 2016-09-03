<?php

namespace Medlib\Events;

use Medlib\Models\User;
use Medlib\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserRegistrationConfirmation extends Event {

    use SerializesModels;

    /**
     * @var \Medlib\Models\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param \Medlib\Models\User $user
     *
     */
    public function __construct(User $user) {
        $this->user = $user;
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