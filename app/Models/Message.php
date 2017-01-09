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
    protected $fillable = ['user_id', 'body', 'sender_id', 'sender_profile_image', 'sender_name'];

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
     * @param int $senderId
     * @param string $senderProfileImage
     * @param string $senderName
     * @return static
     */
    public static function createMessage($body, $senderId, $senderProfileImage, $senderName)
    {
        $message = new static([
            'body' => $body,
            'sender_id' => $senderId,
            'sender_profile_image' => $senderProfileImage,
            'sender_name' => $senderName]);

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
     * @param int $userId
     *
     * @return mixed
     */
    public function belongsToUser($userId)
    {
        $users = $this->users()->get();

        $userIds = [];

        foreach ($users as $user) {
            $userIds[] = $user->id;
        }

        return in_array($userId, $userIds);
    }
}
