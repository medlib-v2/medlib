<?php

namespace Medlib\Realtime;

class Chat extends Realtime
{

    /**
     * Send chat message
     *
     * @param int $userId
     * @param int $clientCode
     * @param int $fromId
     * @param string $message
     */
    public function sendMessageTo($userId = null, $clientCode = null, $fromId = null, $message = null)
    {
        $this->broadcastTo($userId, $clientCode, $fromId, $message);
    }
}
