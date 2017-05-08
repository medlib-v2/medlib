<?php

namespace Medlib\RealTime;

class Events extends RealTime
{
    /**
     * Update chat status bar of current user and her friends with chat status update.
     *
     * @param array $userIds
     * @param int $clientCode
     * @param int $relatedToId
     * @param string $message
     *
     * @return void
     *
     */
    public function updateChatStatusBar(array $userIds, int $clientCode, int $relatedToId, string $message)
    {
        $this->broadcastToAll($userIds, $clientCode, $relatedToId, $message);
    }

    /**
     * Update the chat list of a connected user when a friend has unfriended her.
     *
     * @param int $userId
     * @param int $clientCode
     * @param int $relatedToId
     * @param string $message
     *
     * @return void
     */
    public function updateChatListFriendRemoved(int $userId, int $clientCode, int $relatedToId, string $message)
    {
        $this->broadcastTo($userId, $clientCode, $relatedToId, $message);
    }

    /**
     * Send chat message
     *
     * @param int $userId
     * @param int $clientCode
     * @param int $fromId
     * @param string $message
     */
    public function sendMessageTo(int $userId, int $clientCode, int $fromId, string $message)
    {
        $this->broadcastTo($userId, $clientCode, $fromId, $message);
    }
}
