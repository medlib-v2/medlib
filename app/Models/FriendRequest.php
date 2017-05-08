<?php

namespace Medlib\Models;

use Medlib\Models\User;
use Illuminate\Database\Eloquent\Model;

class FriendRequest extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'friend_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'requester_id'];

    /**
     * A feed belongs to a User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Send a friend request to a user
     *
     * @param  int $requesterId
     * @return FriendRequest
     */
    public static function prepareFriendRequest(int $requesterId)
    {
        $friendRequest = new static([
            'requester_id' => $requesterId
        ]);

        return $friendRequest;
    }
}
