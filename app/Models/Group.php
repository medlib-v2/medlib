<?php

namespace Medlib\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
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
    protected $fillable = ['timeline_id', 'type', 'active', 'member_privacy', 'post_privacy'];

    /**
     * Get the user's  name.
     *
     * @param string $value
     *
     * @return string
     */
    public function getNameAttribute($value)
    {
        return $this->timeline->name;
    }

    /**
     * Get the user's  username.
     *
     * @param string $value
     *
     * @return string
     */
    public function getUsernameAttribute($value)
    {
        return $this->timeline->username;
    }

    /**
     * Get the user's  avatar.
     *
     * @param string $value
     *
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        return $this->timeline->avatar ? $this->timeline->avatar->source : null;
    }

    /**
     * Get the user's  cover.
     *
     * @param string $value
     *
     * @return string
     */
    public function getCoverAttribute($value)
    {
        return $this->timeline->cover ? $this->timeline->cover->source : null;
    }

    /**
     * Get the user's  about.
     *
     * @param string $value
     *
     * @return string
     */
    public function getAboutAttribute($value)
    {
        return $this->timeline->about ? $this->timeline->about : null;
    }

    /**
     * @return array
     */
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
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'group_user', 'group_id', 'user_id')->withPivot('status', 'user_id', 'role_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feeds()
    {
        return $this->hasMany(Feed::class);
    }

    /**
     * @param int $role_id
     * @return bool
     */
    public function roleName($role_id)
    {
        $role = Role::find($role_id);
        $result = $role ? $role->name : false;

        return $result;
    }

    /**
     * @param int $user_id
     * @return bool
     */
    public function isAdmin($user_id)
    {
        $admin_role_id = Role::where('name', 'admin')->first();
        $groupUser = $this->users()->where('user_id', $user_id)->where('role_id', $admin_role_id->id)->where('status', 'approved')->first();

        $result = $groupUser ? true : false;

        return $result;
    }

    /**
     * @return bool
     */
    public function pendingMembers()
    {
        $user_role_id = Role::where('name', 'user')->first();
        $pending_members = $this->users()->where('role_id', $user_role_id->id)->where('status', 'pending')->get();

        $result = $pending_members ? $pending_members : false;

        return $result;
    }

    /**
     * @return bool
     */
    public function members()
    {
        $admin_role_id = Role::where('name', '=', 'admin')->first();
        $members = $this->users()->where('role_id', '!=', $admin_role_id->id)->where('status', 'approved')->get();

        $result = $members ? $members : false;

        return $result;
    }

    /**
     * @return bool
     */
    public function admins()
    {
        $admin_role_id = Role::where('name', '=', 'admin')->first();
        $admins = $this->users()->where('role_id', $admin_role_id->id)->where('status', 'approved')->get();

        $result = $admins ? $admins : false;

        return $result;
    }

    // public function pending_users()
    // {
    //     $admin_role_id = Role::where('name', '=', 'admin')->first();
    //     $pending_users = $this->users()->where('role_id','!=',$admin_role_id->id)->where('status','pending')->get();
    //     $result = $pending_users ? $pending_users : false;
    //     return $result;
    // }

    /**
     * @param int $group_id
     * @param int $user_id
     * @return array|bool|null|\stdClass
     */
    public function chkGroupUser($group_id, $user_id)
    {
        $group_user = DB::table('group_user')->where('group_id', $group_id)->where('user_id', $user_id)->first();
        $result = $group_user ? $group_user : false;

        return $result;
    }

    /**
     * @param int $group_user_id
     * @return bool
     */
    public function updateStatus($group_user_id)
    {
        $group_user = DB::table('group_user')->where('id', $group_user_id)->update(['status' => 'approved']);
        $result = $group_user ? true : false;

        return $result;
    }

    /**
     * @param int $group_user_id
     * @return bool
     */
    public function decilneRequest($group_user_id)
    {
        $group_user = DB::table('group_user')->where('id', $group_user_id)->delete();
        $result = $group_user ? true : false;

        return $result;
    }

    /**
     * @param int $group_id
     * @param int $user_id
     * @return bool
     */
    public function removeMember($group_id, $user_id)
    {
        $group_user = DB::table('group_user')->where('group_id', $group_id)->where('user_id', $user_id)->delete();

        $result = $group_user ? true : false;

        return $result;
    }

    /**
     * @param string $member_role
     * @param string $group_id
     * @param int $user_id
     * @return bool
     */
    public function updateMemberRole($member_role, $group_id, $user_id)
    {
        $group_user = DB::table('group_user')->where('group_id', $group_id)->where('user_id', $user_id)->update(['role_id' => $member_role]);
        $result = $group_user ? true : false;

        return $result;
    }
}
