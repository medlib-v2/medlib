<?php

namespace Medlib\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RestartSocketServer extends Event implements ShouldBroadcast
{
    public $message;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->message = 'restart';
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['restart'];
    }
}
