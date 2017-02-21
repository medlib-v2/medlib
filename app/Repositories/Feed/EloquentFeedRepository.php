<?php

namespace Medlib\Repositories\Feed;

use Medlib\Models\User;
use Medlib\Models\Feed;

class EloquentFeedRepository implements FeedRepository
{
    /**
     * Get feeds posted by current user and friends.
     *
     * @param \Medlib\Models\User $user
     * @return mixed
     */
    public function getPublishedByUserAndFriends(User $user)
    {
        $friendsUserIds = $user->friends()->pluck('requester_id');
        $friendsUserIds[] = $user->id;
        return Feed::whereIn('user_id', $friendsUserIds)->latest()->paginate(15);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function getPublishedByUser(User $user)
    {
        return $user->feeds()->paginate(8);
    }


    /**
     * Get feeds posted by current user and friends via ajax.
     *
     * @param \Medlib\Models\User $user
     * @param int $startingPoint
     * @return mixed
     */
    public function getPublishedByUserAndFriendsAjax(User $user, $startingPoint)
    {
        $friendsUserIds = $user->friends()->pluck('requester_id');
        $friendsUserIds[] = $user->id;
        return Feed::whereIn('user_id', $friendsUserIds)->latest()->skip($startingPoint)->take(10)->get();
    }
}
