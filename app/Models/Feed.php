<?php

namespace Medlib\Models;

use Medlib\Models\Like;
use Medlib\Models\User;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model {

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'feeds';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'body', 'poster_firstname', 'poster_profile_image'];
    /**
     * A feed belongs to a User.
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     *  Publish a new feed.
     *
     *	@param string $body
     *	@param string $poster_firstname
     *	@param string $poster_profile_image
     *
     *	@return static
     */
    public static function publish($body, $poster_firstname, $poster_profile_image) {
        $feed = new static(compact('body', 'poster_firstname', 'poster_profile_image'));

        return $feed;
    }

    /**
     *  Get the amount of feeds related to current User.
     *
     *	@param array $userIds
     *
     *	@return int
     */
    public static function getTotalCountFeedsForUser($userIds) {
        return self::whereIn('user_id', $userIds)->count();
    }

    /**
     * 2nd arg is parsing the name of  the polymorphic relation
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function likes() {
        return $this->morphMany(Like::class, 'likes');
    }
    
    
    /**
     * Return the timestamps
     * @return array
     */
    public function getDates() {
        return ['created_at', 'updated_at'];
    }

    /**
     * Return the First name publisher
     * @return mixed
     */
    public function getFirstNamePublisher() {
        return $this->poster_firstname;
    }

    /**
     * Return the Avatar of publisher
     * @return mixed
     */
    public function getAvatarPublisher() {
        return $this->poster_profile_image;
    }

    /**
     * Return the current content body
     * @return mixed
     */
    public function getContent() {
        return $this->body;
    }

}
