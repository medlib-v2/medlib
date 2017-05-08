<?php

namespace Medlib\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'messages';

    /**
     * These fields could be mass assigned
     */
    protected $fillable = [
        'body',
        'sender_id',
        'receiver_id',
        'conversation_id'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * A message belongs to Many Users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * A Message be longs to message conversation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id', 'id');
    }

    /**
     * Create a new message object.
     *
     * @param string $body
     * @param int $senderId
     * @param int $receiverId
     * @param int $conversationId
     *
     * @return Model
     */
    public static function createMessage(string $body, int $senderId, int $receiverId, int $conversationId)
    {
        $message = static::create([
            'body' => $body,
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'conversation_id' => $conversationId
        ]);

        return $message;
    }

    /**
     * Determine if a message belongs to a user.
     *
     * @param int $userId
     *
     * @return mixed
     */
    public function belongsToUser(int $userId)
    {
        $users = $this->users()->get();

        $userIds = [];

        foreach ($users as $user) {
            $userIds[] = $user->id;
        }

        return in_array($userId, $userIds);
    }

    /**
     * @param $date
     * @return mixed
     */
    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->copy()->tz(Auth::user()->timezone)->format('Y-m-d\TH:i:s\Z');
    }

    /**
     * @param $date
     * @return mixed
     */
    public function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d\TH:i:s\Z');
    }
}
