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
        $this->client = new Client(new Version1X(env('SOCKET_URL')));
    }

    /**
     * Send a websocket broadcast to all connected users.
     *
     * @param array $user_ids
     * @param $client_code
     * @param $related_to_id
     * @param string $message
     */
    public function broadcastToAll($user_ids = [], $client_code = "", $related_to_id = "", $message = "")
    {
        if (!empty($user_ids)) {
            $this->client->initialize();
            foreach ($user_ids as $user_id) {
                $this->client->emit('broadcast', [
                    'user_id' => $user_id,
                    'receiver_id' => $user_id,
                    'related_to_id' => $related_to_id,
                    'client_code' => $client_code,
                    'message' => $message
                ]);
            }
        }

        $this->client->close();
    }

    /**
     * Send a websocket broadcast to one connected user.
     *
     * @param $user_id
     * @param $client_code
     * @param $related_to_id
     * @param $message
     */
    public function broadcastTo($user_id = "", $client_code = "", $related_to_id = "", $message = "")
    {
        $this->client->initialize();

        $this->client->emit('broadcast', [
            'user_id' => $user_id,
            'receiver_id' => $user_id,
            'related_to_id' => $related_to_id,
            'client_code' => $client_code,
            'message' => $message
        ]);

        $this->client->close();
    }
}
