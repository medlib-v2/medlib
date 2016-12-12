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
     *	@param int $howMany
     *	@param string $byFirstname
     *
     *	@return mixed
     */
    public function getPaginated($howMany = 10, $byFirstname = null)
    {
        if (is_null($byFirstname)) {
            return User::whereNotIn('id', [Auth::user()->id])->orderBy('first_name', 'asc')->paginate($howMany);
        }
        
        return User::whereNotIn('id', [Auth::user()->id])->where('first_name', 'like', '%'.$byFirstname.'%')->orderBy('first_name', 'asc')->paginate($howMany);
    }
    /**
     * Fetch a user by username
     *
     * @param int $username
     *
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
     *
     * @return mixed
     */
    public function findById($id)
    {
        return User::find($id);
    }

    /**
     * Fetch many users by id
     *
     * @param Collection $ids
     *
     * @return mixed
     */
    public function findManyById(Collection $ids)
    {
        $users = [];

        foreach ($ids as $id) {
            $users[] = $this->findById($id);
        }

        return    $users;
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
        return User::find($id)->messages()->paginate(10);
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
}
