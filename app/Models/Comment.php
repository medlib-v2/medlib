<?php

namespace Medlib\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Comment extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comments';

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
    protected $fillable = ['feed_id', 'comment', 'user_id', 'parent_id'];

    /**
     * @var array
     */
    //public $with = ['user', 'feed'];
    public $with = ['user'];

    /**
     * Comment owned by Author.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Comment hase many to feed.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    /**
    public function feed()
    {
        return $this->belongsToMany(Feed::class);
    }
    **/

    /**
     * @return mixed
     */
    public function comments_liked()
    {
        return $this->belongsToMany(User::class, 'comment_likes', 'comment_id', 'user_id');
    }

    /**
     * @return mixed
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id')->latest();
    }
}
