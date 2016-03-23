<?php

namespace Medlib\Models;

use Medlib\Models\User;
use Illuminate\Database\Eloquent\Model;

class FriendRequest extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'requester_id'];


    /**
     * A feed belongs to a User.
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Send a friend request to a user
     *
     *
     * @attr int $requester_id
     *
     */
    public static function prepareFriendRequest($requester_id)
    {
        $FriendRequest = new static(compact('requester_id'));

        return $FriendRequest;
    }

}