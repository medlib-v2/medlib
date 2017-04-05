<?php

namespace Medlib\Repositories\FriendRequest;

use Medlib\Models\User;

interface FriendRequestRepository
{
    public function getIdsThatSentRequestToCurrentUser($id);
}
