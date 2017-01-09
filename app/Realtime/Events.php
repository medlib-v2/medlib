<?php

namespace Medlib\RealTime;

class Events extends RealTime
{

    /**
     * Update chat status bar of current user and her friends with chat status update.
     *
     * @param array $user_ids
     * @param $client_code
     * @param $related_to_id
     *
     * @param string $message
     * @return void
     *
     */
    public function updateChatStatusBar($user_ids = [], $client_code = "", $related_to_id = "", $message = "")
    {
        $this->broadcastToAll($user_ids, $client_code, $related_to_id, $message);
    }

    /**
     * Update the chat list of a connected user when a friend has unfriended her.
     *
     * @param $user_id
     * @param int $client_code
     * @param $related_to_id
     * @param string $message
     *
     * @return void
     */
    public function updateChatListFriendRemoved($user_id = "", $client_code = null, $related_to_id = "", $message = "")
    {
        $this->broadcastTo($user_id, $client_code, $related_to_id, $message);
    }

    /**
     * Send chat message
     *
     * @param int $user_id
     * @param int $client_code
     * @param int $from_id
     * @param string $message
     */
    public function sendMessageTo($user_id = null, $client_code = null, $from_id = null, $message = null)
    {
        $this->broadcastTo($user_id, $client_code, $from_id, $message);
    }
}
