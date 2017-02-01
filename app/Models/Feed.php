<?php

namespace Medlib\Models;

use Carbon\Carbon;
use Medlib\Models\Like;
use Medlib\Models\User;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{

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
    protected $fillable = ['user_id', 'body', 'poster_username', 'poster_profile_image', 'image_url', 'video_url', 'location'];

    /**
     * The attributes excluded from the model's JSON form.
     * @var array
     */
    protected $hidden = ['poster_username', 'poster_profile_image'];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];


    /**
     * @var array
     */
    public $with = ['user','likes', 'comments'];

    /**
     * A feed belongs to a User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A feed belongs to a Comment.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comments()
    {
        return $this->belongsTo(Comment::class);
    }

    /**
     * Publish a new feed.
     *
     * @param string $body
     * @param string $poster_username
     * @param string $poster_profile_image
     * @param string $image_url
     * @param string $video_url
     * @param string $location
     *
     * @return static
     */
    public static function publish($body, $poster_username, $poster_profile_image, $image_url = null, $video_url = null, $location = null)
    {
        $feed = new static(compact('body', 'poster_username', 'poster_profile_image', 'image_url', 'video_url', 'location'));
        return $feed;
    }

    /**
     * Get the amount of feeds related to current User.
     *
     * @param array $userIds
     *
     * @return int
     */
    public static function getTotalCountFeedsForUser($userIds)
    {
        return self::whereIn('user_id', $userIds)->count();
    }


    /**
     * 2nd arg is parsing the name of  the polymorphic relation
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Return the id publisher
     * @return mixed
     */
    public function getFeedId()
    {
        return $this->id;
    }

    /**
     * Return the timestamps
     * @return array
     */
    public function getDates()
    {
        return ['created_at', 'updated_at'];
    }

    /**
     * Return the First name publisher
     * @return mixed
     */
    public function getUsernamePublisher()
    {
        return $this->poster_username;
    }

    /**
     * Return the Avatar of publisher
     * @return mixed
     */
    public function getAvatarPublisher()
    {
        return $this->poster_profile_image;
    }

    /**
     * Return the Image link  of publisher
     *
     * @return mixed
     */
    public function getImagePath()
    {
        return $this->image_url;
    }

    /**
     * Return the Image link  of publisher
     *
     * @return mixed
     */
    public function getVideoPath()
    {
        return $this->video_url;
    }

    /**
     * Return the current content body
     *
     * @return mixed
     */
    public function getContent()
    {
        return $this->body;
    }

    /**
     * Return the current location
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Get formatted post date
     *
     * @return string
     */
    public function getPublishAt()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    /**
     * Get formatted post date
     *
     * @return string
     */
    public function publishAt()
    {
        return $this->created_at->format('d/m/Y');
    }

    /**
     * Used to fetch youtube video id
     *
     * @param $url
     */
    public static function getYoutubeId($url)
    {
        $parse = parse_url($url);

        if (!empty($parse['query'])) {
            preg_match("/v=([^&]+)/i", $url, $matches);
            return $matches[1];
        } else {
            /**
             * to get basename
             */
            $info = pathinfo($url);
            return $info['basename'];
        }
    }
}
