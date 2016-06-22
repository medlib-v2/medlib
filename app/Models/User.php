<?php

namespace Medlib\Models;

use Carbon\Carbon;
use Medlib\Models\Feed;
use Medlib\Models\Message;
use Illuminate\Support\Str;
use Medlib\Models\FriendRequest;
use Medlib\Models\MessageResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'profession',
        'location',
        'date_of_birth',
        'gender',
        'user_active',
        'account_type',
        'user_avatar',
        'confirmation_code'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'confirmation_code',
        'created_at',
        'updated_at',
        'user_active'
    ];

    /**
     * A User can have many feeds.
     *
     * @return mixed
     */
    public function feeds() {

        return $this->hasMany(Feed::class)->latest();
    }

    /**
     * A User can have many friend requests.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function friendRequests() {

        return $this->hasMany(FriendRequest::class);
    }

    /**
     * A user can have many friends.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function friends() {
        return $this->belongsToMany(Self::class, 'friends', 'requested_id', 'requester_id')->withTimestamps();
    }

    /**
     * A user belons to many messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function messages() {
        return $this->belongsToMany(Message::class)->withTimestamps();
    }

    /**
     * A user belons to many comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function comments() {
        return $this->belongsToMany(Comment::class)->withTimestamps();
    }

    /**
     * A user has many message responses.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function messageResponses() {

        return $this->belongsToMany(MessageResponse::class)->withTimestamps();
    }

    /**
     * Register a new Medlib user.
     *
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string $first_name
     * @param string $last_name
     * @param string $profession
     * @param string $location
     * @param string $date_of_birth
     * @param string $gender
     * @param string $user_active
     * @param string $account_type
     * @param string $user_avatar
     * @param string $confirmation_code
     *
     * @return User $user
     */
    public static function register($username, $email, $password, $first_name, $last_name, $profession, $location, $date_of_birth, $gender, $user_active, $account_type, $user_avatar, $confirmation_code) {
        $user = new static(
            compact('username', 'email', 'password', 'first_name', 'last_name', 'profession', 'location', 'date_of_birth', 'gender', 'user_active', 'account_type', 'user_avatar', 'confirmation_code')
        );

        return $user;
    }

    /**
     * Add a friend to a user.
     *
     * @param int $requesterUser_id
     * @return mixed
     */
    public function createFriendShipWith($requesterUser_id) {
        return $this->friends()->attach($requesterUser_id, ['requested_id' => $this->id, 'requester_id' => $requesterUser_id]);
    }


    /**
     * Remove a friend from a user.
     *
     * @param int $requesterUser_id
     * @return mixed
     */
    public function finishFriendshipWith($requesterUser_id) {
        return $this->friends()->detach($requesterUser_id, ['requested_id' => $this->id, 'requester_id' => $requesterUser_id]);
    }

    /**
     * Update the online status of current user
     *
     * @param int $status
     * @return mixed
     */
    public function updateOnlineStatus($status) {
        $this->onlinestatus = $status;
        $this->save();
    }

    /**
     * Determine if current user is friends with another user.
     *
     * @param int $otherUser_id
     * @return boolean
     */
    public function isFriendsWith($otherUser_id) {
        $currentUserFriends = DB::table('friends')->where('requester_id', $this->id)->lists('requested_id');
        return in_array($otherUser_id, $currentUserFriends);
    }

    /**
     * Determine if current user has sent a friend request to another user.
     *
     * @param int $otherUser_id
     * @return boolean
     */
    public function sentFriendRequestTo($otherUser_id) {
        $friendRequestedByCurrentUser = DB::table('friend_requests')->where('requester_id', $this->id)->lists('user_id');
        return in_array($otherUser_id, $friendRequestedByCurrentUser);
    }

    /**
     * Determine if current user has received a friend request from another user.
     *
     * @param int $otherUser_id
     * @return boolean
     */
    public function receivedFriendRequestFrom($otherUser_id) {
        $friendRequestsReceivedByCurrentUser = DB::table('friend_requests')->where('user_id', $this->id)->lists('requester_id');
        return in_array($otherUser_id, $friendRequestsReceivedByCurrentUser);
    }


    /**
     * Determine if the current user is the same as the given one.
     *
     * @param int $id
     * @return boolean
     */
    public function is($id) {
        return $this->id == $id;
    }

    /**
     * Determine if current user is available to chat.
     * @return boolean
     */
    public function isAvailableToChat() {
        return $this->chatstatus;
    }

    /**
     * Update current user's chat status.
     *
     * @param  boolean $chatStatus
     * @return mixed
     */
    public function updateChatStatus($chatStatus) {
        $this->chatstatus = $chatStatus;

        $this->save();
    }

    /**
     * Determine if current user is online.
     * @return boolean
     */
    public function isOnline() {

        return $this->onlinestatus;
    }

    /**
     * Return the name of this current user
     * @return null|string
     */
    public function getName() {

        if($this->first_name && $this->last_name) {

            return Str::ucfirst($this->first_name)." ".Str::upper($this->last_name);
        }

        if($this->first_name) {
            return Str::ucfirst($this->first_name);
        }

        return null;
    }

    /**
     * Return the nick name of this current user
     * @return mixed
     */
    public function getUsername() {

        return $this->username;
    }

    /**
     * Return the family name if is define else
     * return the nick name if not define
     * @return mixed
     */
    public function getNameOrUsername() {

        return $this->getName() ?: $this->getUsername();
    }

    /**
     * Return avatar url if the user_avatar is define.
     * return default.jpg if not define
     *
     * @return url
     */
    public function getAvatar() {
            return $this->user_avatar ?: url('/avatars/default.jpg');
    }

    /**
     * Return the first name if isset else return the nick name
     * @return mixed
     */
    public function getFirstNameOrUsername() {
        return $this->getFirstName() ?: $this->getUsername();
    }

    /**
     * Return the Profession of this current user
     * @return string
     */
    public function getProfession() {
        if($this->profession) return Str::ucfirst($this->profession);
    }

    /**
     * Return the first name of this current user
     * @return string
     */
    public function getFirstName() {
        return Str::ucfirst($this->first_name);
    }

    /**
     * Return the family name of this current user
     * @return string
     */
    public function getLastName() {
        return Str::upper($this->last_name);
    }

    /**
     * Return the email address oh this current user
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Check if this current user is actived your account
     * @return bool
     */
    public function userAccountIsActive() {

        if(!$this->user_active == true) {
            return false;
        }
        return true;
    }

    /**
     * Return the address of this current user
     * @return string
     */
    public function getLocation() {

        if($this->location)
            return Str::ucfirst($this->location);
        else
            return Str::ucfirst("Paris, France");
    }

    /**
     * Return the confirmation code if isset else return null
     * @return mixed
     */
    public function getConfirmationCode() {
        return $this->confirmation_code;
    }

    /**
     * Return date of birth this current user
     * @return string
     */
    public function getBirthDay() {

     return Carbon::createFromFormat('Y-m-d', $this->date_of_birth)->toFormattedDateString();

    }

    /**
     * Return the gender of this current user
     * @return string
     */
    public function getGender() {
        return Str::ucfirst($this->gender);
    }

    /**
     * Return the statement query
     * @param $username
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function whereUsername($username){
        return self::where('username', $username);
    }
}
