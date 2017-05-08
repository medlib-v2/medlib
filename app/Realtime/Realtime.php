<?php

namespace Medlib\RealTime;

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version1X;

abstract class RealTime
{
    /**
     * @var Object
     */
    protected $client;

    /**
     * Create a new RealTime instance.
     */
    public function __construct()
    {
        $this->client = new Client(new Version1X(config('medlib.socket_url')));
    }

    /**
     * Send a websocket broadcast to all connected users.
     *
     * @param array $userIds
     * @param int $clientCode
     * @param int $relatedToId
     * @param string $message
     */
    public function broadcastToAll(array $userIds, int $clientCode, int $relatedToId, string $message)
    {
        if (!empty($userIds)) {
            $this->client->initialize();
            foreach ($userIds as $userId) {
                $this->client->emit('broadcast', [
                    'user_id' => $userId,
                    'receiver_id' => $userId,
                    'related_to_id' => $relatedToId,
                    'client_code' => $clientCode,
                    'message' => $message
                ]);
            }
        }

        $this->client->close();
    }

    /**
     * Send a websocket broadcast to one connected user.
     *
     * @param int $userId
     * @param int $clientCode
     * @param int $relatedToId
     * @param string $message
     */
    public function broadcastTo($userId, int $clientCode, int $relatedToId, string $message)
    {
        $this->client->initialize();

        $this->client->emit('broadcast', [
            'user_id' => $userId,
            'receiver_id' => $userId,
            'related_to_id' => $relatedToId,
            'client_code' => $clientCode,
            'message' => $message
        ]);

        $this->client->close();
    }
}
