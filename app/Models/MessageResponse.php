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
    protected $fillable = ['message_id','open', 'body', 'senderid', 'receiverid', 'senderprofileimage', 'sendername'];

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
     * @param int $senderId
     * @param int $receiverId
     * @param string $senderProfileImage
     * @param string $senderName
     *
     * @return static
     */
    public static function createMessageResponse($body, $senderId, $receiverId, $senderProfileImage, $senderName)
    {
        $response = new static([

            'body' => $body,
            'senderid' => $senderId,
            'receiverid' => $receiverId,
            'senderprofileimage' => $senderProfileImage,
            'sendername' => $senderName]);

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
     *  Determine if message response was opened by current user.
     *
     *	@param int $userId
     *
     *	@return boolean
     */
    public function hasBeenOpenedBy($userId)
    {
        return DB::table('message_response_user')->where('user_id', $userId)->where('message_response_id', $this->id)->pluck('open');
    }


    /**
     *  Determine if message response was sent by a user.
     *
     *	@param int $userId
     *
     *	@return boolean
     */
    public function wasSentByThisUser($userId)
    {
        return ($this->senderid == $userId) ? true : false;
    }
}
