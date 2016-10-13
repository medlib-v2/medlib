<?php

namespace Medlib\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    
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
     * Comment owned by Author.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() {
        /**  return $this->hasMany(Book::class); **/
        return $this->belongsToMany(User::class, 'user_id');
    }

    /**
     * Comment hase many to feed.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feed() {
        return $this->hasMany(Feed::class);
    }
}