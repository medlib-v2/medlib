<?php

namespace Medlib\Repositories\User;

use Medlib\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class EloquentUserRepository implements UserRepository
{
    /**
     * Get a paginated list of all users
     *
     * @param int $howMany
     * @param string $byFirstName
     * @return mixed
     */
    public function getPaginated($howMany = 10, $byFirstName = null)
    {
        if (is_null($byFirstName)) {
            return User::whereNotIn('id', [Auth::user()->id])->orderBy('first_name', 'asc')->paginate($howMany);
        }
        
        return User::whereNotIn('id', [Auth::user()->id])->where('first_name', 'like', '%'.$byFirstName.'%')->orderBy('first_name', 'asc')->paginate($howMany);
    }

    /**
     * Fetch a user by username
     *
     * @param int $username
     * @return mixed
     */
    public function findByUsername($username)
    {
        return User::whereUsername($username)->first();
    }

    /**
     * Fetch a user by id
     *
     * @param int $id
     * @return mixed
     */
    public function findById($id)
    {
        return User::find($id);
    }

    /**
     * Fetch many users by id
     *
     * @param Collection $collectionIds
     * @return mixed
     */
    public function findManyById(Collection $collectionIds)
    {
        /**
        $users = $collection->map(function($id) {
            dd($this->findById($id));
            return $this->findById($id);
        });
        **/
        $users = [];
        foreach ($collectionIds as $id) {
            $users[] = $this->findById($id);
        }
        return $users;
    }


    /**
     * Fetch a user by id with feeds attached
     *
     * @param int $id
     *
     * @return mixed
     */
    public function findByIdWithFeeds($id)
    {
        return User::with([
            'feeds' => function ($query) {
                $query->latest();
            }])->findOrFail($id);
    }


    /**
     * Fetch a user by id with emails attached
     *
     * @param int $id
     *
     * @return mixed
     */
    public function findByIdWithMessages($id)
    {
        return User::find($id)->messages()->orderBy('created_at', 'desc')->paginate(10);
    }

    /**
     * Fetch friend requests for a user
     *
     * @param int $userId
     *
     * @return mixed
     */
    public function findByIdWithFriendRequests($userId)
    {
        $user = User::with([
            'friendRequests' => function ($query) {
                $query->latest();
            }])->findOrFail($userId)->toArray();
        return $user['friend_requests'];
    }
    
    /**
     * Fetch friends for a user
     *
     * @param int $userId
     *
     * @return mixed
     */
    public function findByIdWithFriends($userId)
    {
        $user = User::with([
            'friends' => function ($query) {
                $query->orderBy('first_name', 'desc');
            }])->findOrFail($userId)->toArray();
        
        return $user['friends'];
    }

    /**
     * Fetch a user by id with timeline attached
     *
     * @param int $id
     *
     * @return mixed
     */
    public function findByTimelineId($id)
    {
        return User::where('timeline_id', $id)->first();
    }
}
