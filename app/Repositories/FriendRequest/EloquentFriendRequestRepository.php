<?php

namespace Medlib\Repositories\FriendRequest;

use Medlib\Models\User;
use Medlib\Models\FriendRequest;
use Illuminate\Support\Facades\DB;

class EloquentFriendRequestRepository implements FriendRequestRepository
{
    public function getIdsThatSentRequestToCurrentUser($id)
    {
        return DB::table('friend_requests')->where('user_id', $id)->pluck('requester_id');
    }
}
