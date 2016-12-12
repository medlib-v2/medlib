<?php

namespace Medlib\Repositories\Feed;

use Medlib\Models\User;

interface FeedRepository
{
    public function getPublishedByUserAndFriends(User $user);

    public function getPublishedByUser(User $user);
    
    public function getPublishedByUserAndFriendsAjax(User $user, $skipQty);
}
