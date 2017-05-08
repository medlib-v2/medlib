<?php

namespace Medlib\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'timeline_id',
        'category_id',
        'message_privacy',
        'timeline_post_privacy',
        'member_privacy',
        'address',
        'active',
        'phone',
        'website',
        'verified'
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
    ];

    /**
     * Get the user's  name.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->timeline->name;
    }

    /**
     * Get the user's  username.
     *
     * @return string
     */
    public function getUsernameAttribute()
    {
        return $this->timeline->username;
    }

    /**
     * Get the user's  avatar.
     *
     * @return string
     */
    public function getAvatarAttribute()
    {
        return $this->timeline->avatar ? $this->timeline->avatar->source : null;
    }

    /**
     * Get the user's  cover.
     *
     * @return string
     */
    public function getCoverAttribute()
    {
        return $this->timeline->cover ? $this->timeline->cover->source : null;
    }

    /**
     * Get the user's  about.
     *
     * @return string
     */
    public function getAboutAttribute()
    {
        return $this->timeline->about ? $this->timeline->about : null;
    }

    public function toArray()
    {
        $array = parent::toArray();

        $timeline = $this->timeline->toArray();

        foreach ($timeline as $key => $value) {
            if ($key != 'id') {
                $array[$key] = $value;
            }
        }

        return $array;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function timeline()
    {
        return $this->belongsTo(Timeline::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'page_user', 'page_id', 'user_id')->withPivot('role_id', 'active');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likes()
    {
        return $this->belongsToMany(User::class, 'page_likes', 'page_id', 'user_id');
    }

    /**
     * @param int $userId
     * @return bool
     */
    public function isAdmin(int $userId)
    {
        $adminRoleId = Role::where('name', 'admin')->first();
        $pageUser = $this->users()->where('user_id', '=', $userId)->where('role_id', '=', $adminRoleId->id)->where('page_user.active', 1)->first();


        $result = $pageUser ? true : false;

        return $result;
    }

    /**
     * @return bool
     */
    public function members()
    {
        $adminRoleId = Role::where('name', '=', 'admin')->first();
        $members = $this->users()->where('role_id', '!=', $adminRoleId->id)->where('page_user.active', 1)->get();

        $result = $members ? $members : false;

        return $result;
    }

    /**
     * @return bool
     */
    public function admins()
    {
        $adminRoleId = Role::where('name', '=', 'admin')->first();
        $admins = $this->users()->where('role_id', $adminRoleId->id)->where('page_user.active', 1)->get();

        $result = $admins ? $admins : false;

        return $result;
    }

    /**
     * @param int $pageId
     * @param int $userId
     * @return array|bool|null|\stdClass
     */
    public function chkPageUser(int $pageId, int $userId)
    {
        $pageUser = DB::table('page_user')->where('page_id', '=', $pageId)->where('user_id', '=', $userId)->first();
        $result = $pageUser ? $pageUser : false;

        return $result;
    }

    /**
     * @param int $pageUserId
     * @return bool
     */
    public function updateStatus(int $pageUserId)
    {
        $pageUser = DB::table('page_user')->where('id', $pageUserId)->update(['active' => 1]);
        $result = $pageUser ? true : false;

        return $result;
    }

    /**
     * @param $memberRole
     * @param int $pageId
     * @param int $userId
     * @return bool
     */
    public function updatePageMemberRole($memberRole, int $pageId, int $userId)
    {
        $pageUser = DB::table('page_user')->where('page_id', $pageId)->where('user_id', $userId)->update(['role_id' => $memberRole]);
        $result = $pageUser ? true : false;

        return $result;
    }

    /**
     * @param $pageId
     * @param int $userId
     * @return bool
     */
    public function removePageMember(int $pageId, int $userId)
    {
        $pageUser = DB::table('page_user')->where('page_id', '=', $pageId)->where('user_id', '=', $userId)->delete();

        $result = $pageUser ? true : false;

        return $result;
    }
}
