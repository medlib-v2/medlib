<?php

namespace Medlib\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotificationReadAll implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;
    /**
     * @var int
     */
    public $user_id;
    /**
     * Create a new event instance.
     *
     * @param  int $user_id
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
        $this->dontBroadcastToCurrentUser();
    }
    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [new PrivateChannel("Medlib.Models.User.{$this->user_id}")];
    }
}
