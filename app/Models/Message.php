<?php

namespace Medlib\Models;

use Medlib\Models\User;
use Medlib\Models\MessageResponse;
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
    protected $fillable = ['body', 'sender_id', 'receiver_id'];

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
     * Create a new message object.
     *
     * @param string $body
     * @param int $sender_id
     * @param int $receiver_id
     * @return static
     */
    public static function createMessage($body, $sender_id, $receiver_id)
    {
        $message = new static([
            'body' => $body,
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id]);

        return $message;
    }

    /**
     * A Message has a many message responses.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function messageResponses()
    {
        return $this->hasMany(MessageResponse::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get the last receiver id from the first response attached to an message.
     *
     * @return mixed
     */
    public function getLastReceiverId()
    {
        return $this->messageResponses()->first()->receiverid;
    }

    /**
     * Determine if a message belongs to a user.
     *
     * @param int $user_id
     *
     * @return mixed
     */
    public function belongsToUser($user_id)
    {
        $users = $this->users()->get();

        $user_ids = [];

        foreach ($users as $user) {
            $user_ids[] = $user->id;
        }

        return in_array($user_id, $user_ids);
    }
}
