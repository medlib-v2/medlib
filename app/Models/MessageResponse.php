<?php

namespace Medlib\Models;

use Medlib\Models\User;
use Medlib\Models\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class MessageResponse extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'message_responses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['message_id','open', 'body', 'sender_id', 'receiver_id', 'sender_profile_image', 'sender_name'];

    /**
     * Many Responses belong to many users.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }


    /**
     * Many Responses belong to one Message
     *
     * @return \Medlib\Models\Message
     */
    public function message()
    {
        return $this->belongsTo(Message::class)->withTimestamps();
    }

    /**
     *  Create a new response object.
     *
     * @param string $body
     * @param $sender_id
     * @param $receiver_id
     * @param $sender_profile_image
     * @param $sender_name
     * @return static
     * @internal param int $senderId
     * @internal param int $receiverId
     * @internal param string $senderProfileImage
     * @internal param string $senderName
     *
     */
    public static function createMessageResponse($body, $sender_id, $receiver_id, $sender_profile_image, $sender_name)
    {
        $response = new static([

            'body' => $body,
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'sender_profile_image' => $sender_profile_image,
            'sender_name' => $sender_name]);

        return $response;
    }

    /**
     * Get the message response subject.
     *
     * @return string
     */
    public function getMessageResponseSubject()
    {
        return substr($this->body, 0, 35)."...";
    }


    /**
     * Determine if message response was opened by current user.
     *
     * @param int $userId
     * @return boolean
     */
    public function hasBeenOpenedBy($userId)
    {
        return DB::table('message_response_user')->where('user_id', $userId)->where('message_response_id', $this->id)->pluck('open');
    }


    /**
     * Determine if message response was sent by a user.
     *
     * @param int $userId
     * @return boolean
     */
    public function wasSentByThisUser($userId)
    {
        return ($this->senderid == $userId) ? true : false;
    }
}
