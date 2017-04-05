<?php

namespace Medlib\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    public $table = 'user_settings';

    public $timestamps = false;

    /**
     * The attributes that should be fillable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'comment_privacy',
        'follow_privacy',
        'post_privacy',
        'confirm_follow',
        'timeline_post_privacy',
        'email_follow',
        'email_like_post',
        'email_post_share',
        'email_like_comment',
        'email_reply_comment',
        'email_join_group',
        'email_like_page',
    ];

    /**
     * Get the user that owns the settings.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
