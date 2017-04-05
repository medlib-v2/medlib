<?php

namespace Medlib\Repositories\Feed;

use Medlib\Models\User;
use Medlib\Models\Timeline;

interface FeedRepository
{
    public function getPublishedByUserAndFriends(User $user);

    public function getPublishedByUser(User $user);
    
    public function getPublishedByUserAndFriendsAjax(User $user, $skipQty);

    public function getPublishedByTimelineOrByUser(Timeline $timeline, User $user);
}
