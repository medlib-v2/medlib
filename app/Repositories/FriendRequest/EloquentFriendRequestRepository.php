<?php

namespace Medlib\Repositories\FriendRequest;

use Medlib\Models\User;
use Medlib\Models\FriendRequest;

class EloquentFriendRequestRepository implements FriendRequestRepository
{
    public function getIdsThatSentRequestToCurrentUser($id)
    {
        return FriendRequest::where('user_id', $id)->pluck('requester_id');
    }
}
