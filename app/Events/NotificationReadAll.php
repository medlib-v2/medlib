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
    public $userId;
    /**
     * Create a new event instance.
     *
     * @param  int $userId
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
        $this->dontBroadcastToCurrentUser();
    }
    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [new PrivateChannel("Medlib.Models.User.{$this->userId}")];
    }
}
