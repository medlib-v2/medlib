<?php

namespace Medlib\Repositories\User;

use Medlib\Models\User;
use Illuminate\Support\Collection;

interface UserRepository
{
    public function getPaginated($howMany, $byKeyword);
    public function findByUsername($username);
    public function findById($id);
    public function findManyById(Collection $ids);
    public function findByIdWithFeeds($id);
    public function findByIdWithMessages($id);
    public function findByIdWithFriends($userId);
    public function findByIdWithFriendRequests($id);
    public function findByTimelineId($id);
}
