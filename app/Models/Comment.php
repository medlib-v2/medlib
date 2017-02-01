<?php

namespace Medlib\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comments';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['comment', 'user_id', 'feed_id'];

    /**
     * @var array
     */
    public $with = ['users','feed'];

    /**
     * Comment owned by Author.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'user_id');
    }

    /**
     * Comment hase many to feed.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function feed()
    {
        return $this->belongsToMany(Feed::class);
    }
}
