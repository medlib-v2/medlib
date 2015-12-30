<?php

namespace Medlib\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
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
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * A User can have many feeds.
     *
     * @return collection
     */
    public function feeds()
    {
        return $this->hasMany('Medlib\Models\Feed')->latest();
    }

    /**
     * A User can have many friend requests.
     *
     * @return collection
     */
    public function friendRequests()
    {
        return $this->hasMany('Medlib\Models\FriendRequest');
    }

    /**
     * A user can have many friends.
     *
     * @return Collection
     *
     */
    public function friends() {

        return $this->belongsToMany(Self::class, 'friends', 'requested_id', 'requester_id')->withTimestamps();
    }

    /**
     * A user belons to many messages.
     *
     * @return Collection
     */
    public function messages()
    {
        return $this->belongsToMany('Medlib\Models\Message')->withTimestamps();
    }

    /**
     * A user has many message responses.
     *
     * @return Collection
     */
    public function messageResponses()
    {
        return $this->belongsToMany('Medlib\Models\MessageResponse')->withTimestamps();
    }

    /**
     * Register a new Medlib user.
     *
     * @param string $username
     *
     * @param string $email
     *
     * @param string $password
     *
     * @param string $first_name
     *
     * @param string $last_name
     *
     * @param string $profession
     *
     * @param string $location
     *
     * @param string $date_of_birth
     *
     * @param string $gender
     *
     * @param string $user_active
     *
     * @param string $account_type
     *
     * @param string $user_avatar
     *
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
     * @param int $requestedUserId
     *
     * @return mixed
     */
    public function createFriendShipWith($requesterUserId) {

        return $this->friends()->attach($requesterUserId, ['requested_id' => $this->id, 'requester_id' => $requesterUserId]);
    }


    /**
     * Remove a friend from a user.
     *
     * @param int $requestedUserId
     *
     * @return mixed
     */
    public function finishFriendshipWith($requesterUserId)
    {
        return $this->friends()->detach($requesterUserId, ['requested_id' => $this->id, 'requester_id' => $requesterUserId]);
    }

    /**
     * Update the online status of current user
     *
     * @param int $status
     *
     * @return mixed
     */
    public function updateOnlineStatus($status)
    {
        $this->onlinestatus = $status;

        $this->save();
    }

    /**
     * Determine if current user is friends with another user.
     *
     * @param int $otherUserId
     *
     * @return boolean
     */
    public function isFriendsWith($otherUserId)
    {
        $currentUserFriends = DB::table('friends')->where('requester_id', $this->id)->lists('requested_id');

        return in_array($otherUserId, $currentUserFriends);
    }

    /**
     * Determine if current user has sent a friend request to another user.
     *
     * @param int $otherUserId
     *
     * @return boolean
     */
    public function sentFriendRequestTo($otherUserId)
    {
        $friendRequestedByCurrentUser = DB::table('friend_requests')->where('requester_id', $this->id)->lists('user_id');

        return in_array($otherUserId, $friendRequestedByCurrentUser);
    }

    /**
     * Determine if current user has received a friend request from another user.
     *
     * @param int $otherUserId
     *
     * @return boolean
     */
    public function receivedFriendRequestFrom($otherUserId)
    {
        $friendRequestsReceivedByCurrentUser = DB::table('friend_requests')->where('user_id', $this->id)->lists('requester_id');

        return in_array($otherUserId, $friendRequestsReceivedByCurrentUser);
    }


    /**
     * Determine if the current user is the same as the given one.
     *
     * @param int $id
     *
     * @return boolean
     *
     */
    public function is($id)
    {
        return $this->id == $id;
    }

    /**
     * Determine if current user is available to chat.
     *
     * @return boolean
     */
    public function isAvailableToChat()
    {
        return $this->chatstatus;
    }

    /**
     * Update current user's chat status.
     *
     * @param  boolean $chatStatus
     *
     * @return mixed
     */
    public function updateChatStatus($chatStatus)
    {
        $this->chatstatus = $chatStatus;

        $this->save();
    }

    /**
     * Determine if current user is online.
     *
     * @return boolean
     */
    public function isOnline()
    {
        return $this->onlinestatus;
    }

    public function getName() {

        if($this->first_name && $this->last_name) {

            return Str::ucfirst($this->first_name)." ".Str::upper($this->last_name);
        }

        if($this->first_name) {
            return Str::ucfirst($this->first_name);
        }

        return null;
    }

    public function getUsername() {

        return $this->username;
    }

    public function getNameOrUsername() {

        return $this->getName() ?: $this->username;
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

    public function getFirstNameOrUsername() {

        return $this->first_name ?: $this->username;
    }

    public function getProfession() {

        if($this->profession) return Str::ucfirst($this->profession);
    }

    public function getFirstName() {

        return Str::ucfirst($this->first_name);
    }

    public function getLastName() {

        return Str::upper($this->last_name);
    }

    public function getEmail() {

        return $this->email;
    }

    public function userAccountIsActive() {

        if(!$this->user_active == true) {

            return false;
        }

        return true;
    }

    public function getLocation() {

        if($this->location)
            return Str::ucfirst($this->location);
        else
            return Str::ucfirst("Paris, France");
    }

    public function getConfirmationCode() {
        return $this->confirmation_code;
    }

    public function getBirthDay() {

     return Carbon::createFromFormat('Y-m-d', $this->date_of_birth)->toFormattedDateString();

    }

    public function getGender() {
        return Str::ucfirst($this->gender);
    }
}
