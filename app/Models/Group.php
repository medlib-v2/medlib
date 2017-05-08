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
     * @param int $roleId
     * @return bool
     */
    public function roleName(int $roleId)
    {
        $role = Role::find($roleId);
        $result = $role ? $role->name : false;

        return $result;
    }

    /**
     * @param int $userId
     * @return bool
     */
    public function isAdmin(int $userId)
    {
        $adminRoleId = Role::where('name', 'admin')->first();
        $groupUser = $this->users()->where('user_id', $userId)->where('role_id', $adminRoleId->id)->where('status', 'approved')->first();

        $result = $groupUser ? true : false;

        return $result;
    }

    /**
     * @return bool
     */
    public function pendingMembers()
    {
        $userRoleId = Role::where('name', 'user')->first();
        $pendingMembers = $this->users()->where('role_id', $userRoleId->id)->where('status', 'pending')->get();

        $result = $pendingMembers ? $pendingMembers : false;

        return $result;
    }

    /**
     * @return bool
     */
    public function members()
    {
        $adminRoleId = Role::where('name', '=', 'admin')->first();
        $members = $this->users()->where('role_id', '!=', $adminRoleId->id)->where('status', 'approved')->get();

        $result = $members ? $members : false;

        return $result;
    }

    /**
     * @return bool
     */
    public function admins()
    {
        $adminRoleId = Role::where('name', '=', 'admin')->first();
        $admins = $this->users()->where('role_id', $adminRoleId->id)->where('status', 'approved')->get();

        $result = $admins ? $admins : false;

        return $result;
    }

    // public function pendingUsers()
    // {
    //     $admin_role_id = Role::where('name', '=', 'admin')->first();
    //     $pending_users = $this->users()->where('role_id','!=',$admin_role_id->id)->where('status','pending')->get();
    //     $result = $pending_users ? $pending_users : false;
    //     return $result;
    // }

    /**
     * @param int $groupId
     * @param int $userId
     * @return array|bool|null|\stdClass
     */
    public function chkGroupUser(int $groupId, int $userId)
    {
        $groupUser = DB::table('group_user')->where('group_id', $groupId)->where('user_id', $userId)->first();
        $result = $groupUser ? $groupUser : false;

        return $result;
    }

    /**
     * @param int $groupUserId
     * @return bool
     */
    public function updateStatus(int $groupUserId)
    {
        $groupUser = DB::table('group_user')->where('id', $groupUserId)->update(['status' => 'approved']);
        $result = $groupUser ? true : false;

        return $result;
    }

    /**
     * @param int $groupUserId
     * @return bool
     */
    public function decilneRequest(int $groupUserId)
    {
        $groupUser = DB::table('group_user')->where('id', $groupUserId)->delete();
        $result = $groupUser ? true : false;

        return $result;
    }

    /**
     * @param int $groupId
     * @param int $userId
     * @return bool
     */
    public function removeMember(int $groupId, int $userId)
    {
        $groupUser = DB::table('group_user')->where('group_id', $groupId)->where('user_id', $userId)->delete();

        $result = $groupUser ? true : false;

        return $result;
    }

    /**
     * @param int $memberRole
     * @param int $groupId
     * @param int $userId
     * @return bool
     */
    public function updateMemberRole(int $memberRole, int $groupId, int $userId)
    {
        $groupUser = DB::table('group_user')->where('group_id', $groupId)->where('user_id', $userId)->update(['role_id' => $memberRole]);
        $result = $groupUser ? true : false;

        return $result;
    }
}
