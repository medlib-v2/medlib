<?php

namespace Medlib\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Authenticatable;
//use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, Notifiable, HasPushSubscriptions, SoftDeletes;

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
        'timeline_id',
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'profession',
        'date_of_birth',
        'gender',
        'activated',
        'account_type',
        'user_avatar',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['full_name'];

    /**
     * The attributes excluded from the model's JSON form.
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'activated',
        'account_type',
        'date_of_birth',
        'pivot'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $with = ['profile'];

    /**
     * @return int
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function timeline()
    {
        return $this->belongsTo(Timeline::class);
    }

    /**
     * A User can have many feeds.
     *
     * @return mixed
     */
    public function feeds()
    {
        return $this->hasMany(Feed::class)->orderBy('created_at');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function social()
    {
        return $this->hasMany(SocialAccount::class);
    }

    /**
     * A User can have many friend requests.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function friendRequests()
    {
        return $this->hasMany(FriendRequest::class);
    }

    /**
     * They follow this user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'followee_id', 'follower_id')->withPivot('status');
    }

    /**
     * This user follows them
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'followee_id');
    }

    /**
     * A user can have many friends.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function friends()
    {
        return $this->belongsToMany(User::class, 'friends', 'requested_id', 'requester_id')->withTimestamps();
    }


    public function messages()
    {
        return $this->conversations()->with('messages');
    }

    public function sentConversations()
    {
        return $this->hasMany(Conversation::class, 'sender_id', 'id');
    }

    public function receivedConversations()
    {
        return $this->hasMany(Conversation::class, 'receiver_id', 'id');
    }

    /**
     * @return mixed
     */
    public function conversations()
    {
        return $this->receivedConversations();
        //return $this->hasMany(Conversation::class, 'sender_id', 'id');
        //return $this->belongsToMany(Conversation::class);
    }

    /**
     * A user belons to many messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    /**
    public function messages()
    {
        return $this->belongsToMany(Message::class)->withTimestamps();
    }
    **/


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pages()
    {
        return $this->belongsToMany(Page::class, 'page_user', 'user_id', 'page_id')->withPivot('role_id', 'active');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pageLikes()
    {
        return $this->belongsToMany(Page::class, 'page_likes', 'user_id', 'page_id');
    }

    /**
     * @return bool
     */
    public function ownPages()
    {
        $admin_role_id = Role::where('name', '=', 'admin')->first();
        $own_pages = $this->pages()->where('role_id', $admin_role_id->id)->where('page_user.active', 1)->get();

        $result = $own_pages ? $own_pages : false;

        return $result;
    }

    /**
     * @return bool
     */
    public function ownGroups()
    {
        $admin_role_id = Role::where('name', '=', 'admin')->first();
        $own_groups = $this->groups()->where('role_id', $admin_role_id->id)->where('status', 'approved')->get();

        $result = $own_groups ? $own_groups : false;

        return $result;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_user', 'user_id', 'group_id')->withPivot('role_id', 'status');
    }

    /**
     * A user belons to many comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function comments()
    {
        return $this->belongsToMany(Comment::class)->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getGroup($id)
    {
        return $this->groups()->where('groups.id', $id)->first();
    }

    public function getPage($id)
    {
        return $this->pages()->where('pages.id', $id)->first();
        // $result = $user_page ? $user_page : false;
        // return $result;
    }

    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getFullNameAttribute()
    {
        return $this->getName();
    }

    /**
     * Register a new Medlib User.
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
     * @param string $activated
     * @param string $account_type
     * @param string $user_avatar
     *
     * @return User $user
     */
    public static function register($username, $email, $password, $first_name, $last_name, $profession, $location, $date_of_birth, $gender, $activated, $account_type, $user_avatar)
    {
        $user = new static(
            compact('username', 'email', 'password', 'first_name', 'last_name', 'profession', 'location', 'date_of_birth', 'gender', 'activated', 'account_type', 'user_avatar')
        );

        return $user;
    }

    /**
     * Add a friend to a user.
     *
     * @param int $requester_user_id
     * @return mixed
     */
    public function createFriendShipWith($requester_user_id)
    {
        return $this->friends()->attach($requester_user_id, ['requested_id' => $this->id, 'requester_id' => $requester_user_id]);
    }

    /**
     * Remove a friend from a user.
     *
     * @param int $requester_user_id
     * @return mixed
     */
    public function finishFriendshipWith($requester_user_id)
    {
        return $this->friends()->detach($requester_user_id, ['requested_id' => $this->id, 'requester_id' => $requester_user_id]);
    }

    /**
     * Update the online status of current user
     *
     * @param int $status
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
     * @param int $otherUser_id
     * @return boolean
     */
    public function isFriendsWith($otherUser_id)
    {
        $currentUserFriends = DB::table('friends')->where('requester_id', $this->id)->pluck('requested_id')->toArray();
        return in_array($otherUser_id, $currentUserFriends);
    }

    /**
     * Determine if current user has sent a friend request to another user.
     *
     * @param int $otherUser_id
     * @return boolean
     */
    public function sentFriendRequestTo($otherUser_id)
    {
        $friendRequestedByCurrentUser = DB::table('friend_requests')->where('requester_id', $this->id)->pluck('user_id')->toArray();
        return in_array($otherUser_id, $friendRequestedByCurrentUser);
    }

    /**
     * Determine if current user has received a friend request from another user.
     *
     * @param int $otherUser_id
     * @return boolean
     */
    public function receivedFriendRequestFrom($otherUser_id)
    {
        $friendRequestsReceivedByCurrentUser = FriendRequest::where('user_id', $this->id)->pluck('requester_id')->toArray();
        return in_array($otherUser_id, $friendRequestsReceivedByCurrentUser);
    }

    /**
     * Determine if current user is available to chat.
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
     * @return mixed
     */
    public function updateChatStatus($chatStatus)
    {
        $this->chatstatus = $chatStatus;

        $this->save();
    }

    /**
     * Determine if current user is online.
     * @return boolean
     */
    public function isOnline()
    {
        return $this->onlinestatus;
    }

    /**
     * Return the name of this current user
     * @return null|string
     */
    public function getName()
    {
        if ($this->first_name && $this->last_name) {
            return Str::ucfirst($this->first_name)." ".Str::upper($this->last_name);
        }

        if ($this->first_name) {
            return Str::ucfirst($this->first_name);
        }

        return null;
    }

    /**
     * Return the nick name of this current user
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Return the family name if is define else
     * return the nick name if not define
     * @return mixed
     */
    public function getNameOrUsername()
    {
        return $this->getName() ?: $this->getUsername();
    }

    /**
     * Return avatar url if the user_avatar is define.
     * return default.jpg if not define
     *
     * @return url
     */
    public function getAvatar()
    {
        return $this->user_avatar ?: url('/avatars/default.jpg');
    }

    /**
     * Return the first name if isset else return the nick name
     * @return mixed
     */
    public function getFirstNameOrUsername()
    {
        return $this->getFirstName() ?: $this->getUsername();
    }

    /**
     * Return the Profession of this current user
     * @return string
     */
    public function getProfession()
    {
        if ($this->profession) {
            return Str::ucfirst($this->profession);
        }
    }

    /**
     * Return the first name of this current user
     * @return string
     */
    public function getFirstName()
    {
        return Str::ucfirst($this->first_name);
    }

    /**
     * Return the family name of this current user
     * @return string
     */
    public function getLastName()
    {
        return Str::upper($this->last_name);
    }

    /**
     * Return the email address oh this current user
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Check if this current user is actived your account
     * @return bool
     */
    public function userAccountIsActive()
    {
        if (!$this->activated == true) {
            return false;
        }
        return true;
    }

    /**
     * Return the address of this current user
     * @return string
     */
    public function getLocation()
    {
        if ($this->location) {
            return Str::ucfirst($this->location);
        } else {
            return Str::ucfirst("Paris, France");
        }
    }

    /**
     * Return date of birth this current user
     * @return string
     */
    public function getBirthDay()
    {
        return Carbon::createFromFormat('Y-m-d', $this->date_of_birth)->toFormattedDateString();
    }

    /**
     * Return the gender of this current user
     * @return string
     */
    public function getGender()
    {
        return Str::ucfirst($this->gender);
    }

    /**
     * Return the statement query
     * @param $username
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function whereUsername($username)
    {
        return self::where('username', $username);
    }

    /**
     * Confirm the user.
     *
     * @return void
     */
    public function confirmEmail()
    {
        $this->activated = true;
        $this->save();
    }

    /**
     * @param User $user
     */
    public function followUser(User $user)
    {
        $this->followings()->attach($user->id);
    }

    /**
     * @param User $user
     */
    public function unfollowUser(User $user)
    {
        $this->followings()->detach($user->id);
    }


    public function getUserSettings($user_id)
    {
        $result = DB::table('user_settings')->where('user_id', $user_id)->first();
        return $result;
    }

    public function deleteUserSettings($user_id)
    {
        $result = DB::table('user_settings')->where('user_id', $user_id)->delete();

        return $result;
    }

    public function getOthersSettings($username)
    {
        $timeline = Timeline::where('username', $username)->first();
        $user = self::where('timeline_id', $timeline->id)->first();
        $result = DB::table('user_settings')->where('user_id', $user->id)->first();

        return $result;
    }

    public function getReportsCount()
    {
        $post_reports = DB::table('post_reports')->get();
        $timeline_reports = DB::table('timeline_reports')->get();
        $result1 = count($post_reports);
        $result2 = count($timeline_reports);

        return $result1 + $result2;
    }

    public function updateFollowStatus($user_id)
    {
        $chk_user = DB::table('followers')->where('follower_id', $user_id)->where('followee_id', Auth::user()->id)->first();
        if ($chk_user->status == 'pending') {
            $result = DB::table('followers')->where('follower_id', $user_id)->where('followee_id', Auth::user()->id)->update(['status' => 'approved']);
        }

        $result = $result ? true : false;

        return $result;
    }

    public function decilneRequest($user_id)
    {
        $chk_user = DB::table('followers')->where('follower_id', $user_id)->where('followee_id', Auth::user()->id)->first();
        if ($chk_user->status == 'pending') {
            $result = DB::table('followers')->where('follower_id', $user_id)->where('followee_id', Auth::user()->id)->delete();
        }

        $result = $result ? true : false;

        return $result;
    }

    public function announcements()
    {
        return $this->belongsToMany(Announcement::class, 'announcement_user', 'user_id', 'announcement_id');
    }

    public function chkMyFollower($diff_timeline_id, $login_id)
    {
        $followers = DB::table('followers')->where('follower_id', $diff_timeline_id)->where('followee_id', $login_id)->where('status', '=', 'approved')->first();
        $result = $followers ? true : false;

        return $result;
    }

    public function getUserPrivacySettings($loginId, $others_id)
    {
        $timeline_post_privacy = '';
        $timeline_post = '';
        $user_post = '';
        $result = '';

        $live_user_settings = $this->getUserSettings($others_id);

        if ($live_user_settings) {
            $timeline_post_privacy = $live_user_settings->timeline_post_privacy;
            $user_post_privacy = $live_user_settings->post_privacy;
        }

        //start $this if block is for timeline post privacy settings
        if ($loginId != $others_id) {
            if ($timeline_post_privacy != null && $timeline_post_privacy == 'only_follow') {
                $isFollower = $this->chkMyFollower($others_id, $loginId);
                if ($isFollower) {
                    $timeline_post = true;
                }
            } elseif ($timeline_post_privacy != null && $timeline_post_privacy == 'everyone') {
                $timeline_post = true;
            } elseif ($timeline_post_privacy != null && $timeline_post_privacy == 'nobody') {
                $timeline_post = false;
            }

            //start $this if block is for user post privacy settings
            if ($user_post_privacy != null && $user_post_privacy == 'only_follow') {
                $isFollower = $this->chkMyFollower($others_id, $loginId);
                if ($isFollower) {
                    $user_post = true;
                }
            } elseif ($user_post_privacy != null && $user_post_privacy == 'everyone') {
                $user_post = true;
            }
        } else {
            $timeline_post = true;
            $user_post = true;
        }
        //End
        $result = $timeline_post.'-'.$user_post;

        return $result;
    }
}
