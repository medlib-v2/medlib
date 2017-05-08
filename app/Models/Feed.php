<?php

namespace Medlib\Models;

use Carbon\Carbon;
use Medlib\Models\Like;
use Medlib\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Suppress all rules containing "unused" in this
 * class SqlMigrations
 *
 * @SuppressWarnings("unused")
 * @SuppressWarnings("PHPMD.CyclomaticComplexity")
 * @SuppressWarnings("PHPMD.NPathComplexity")
 * @SuppressWarnings("PHPMD.ExcessivePublicCount")
 */
class Feed extends Model
{
    use SoftDeletes;
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
    protected $fillable = [
        'user_id',
        'timeline_id',
        'body',
        'type',
        'youtube_title',
        'youtube_video_id',
        'location',
        'image_id',
        'image_url',
        'soundcloud_id',
        'soundcloud_title'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];


    /**
     * @var array
     */
    public $with = [
        'user',
        'likes',
        'comments',
        'shared',
        'follows',
        'images'
    ];

    /**
     * A feed belongs to a User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'feed_likes', 'feed_id', 'user_id');
    }

    public function shares()
    {
        return $this->belongsToMany(User::class, 'feed_shares', 'feed_id', 'user_id');
    }

    public function follows()
    {
        return $this->belongsToMany(User::class, 'feed_follows', 'feed_id', 'user_id');
    }


    public function reports()
    {
        return $this->belongsToMany(User::class, 'feed_reports', 'feed_id', 'reporter_id')->withPivot('status');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /**
     * public function comments()
     * {
     * return $this->belongsTo(Comment::class);
     * }
     **/

    /**
     * A feed belongs to a Comment.
     * @return mixed
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest()->where('parent_id', null);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function shared()
    {
        return $this->belongsToMany(User::class, 'feed_shares', 'feed_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function images()
    {
        return $this->belongsToMany(Media::class, 'feed_media', 'feed_id', 'media_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function usersPosts()
    {
        return $this->belongsToMany(User::class, 'feeds', 'id', 'user_id');
    }

    /**
     * @param int $feedId
     * @param int $userId
     * @return bool
     */
    public function managePostReport(int $feedId, int $userId)
    {
        $feedReport = DB::table('feed_reports')->insert(['feed_id' => $feedId, 'reporter_id' => $userId, 'status' => 'pending', 'created_at' => Carbon::now()]);

        $result = $feedReport ? true : false;

        return $result;
    }

    /**
     * @param int $feedId
     * @return bool
     */
    public function checkReports(int $feedId)
    {
        $feedReport = DB::table('feed_reports')->where('feed_id', $feedId)->first();

        $result = $feedReport ? true : false;

        return $result;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function postsLiked()
    {
        $result = DB::table('feed_likes')->get();

        return $result;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function postsReported()
    {
        $result = DB::table('feed_reports')->get();

        return $result;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function postShared()
    {
        $result = DB::table('feed_shares')->get();

        return $result;
    }

    /**
     * @param int $loginId
     * @param int $followerUserId
     * @return bool
     */
    public function chkUserFollower(int $loginId, int $followerUserId)
    {
        $followers = DB::table('followers')->where('follower_id', $followerUserId)->where('followee_id', $loginId)->where('status', '=', 'approved')->first();

        if ($followers) {
            $userSettings = DB::table('user_settings')->where('user_id', $loginId)->first();
            $result = $userSettings ? $userSettings->comment_privacy : false;

            return $result;
        }
    }

    /**
     * @param int $loginId
     * @return bool
     */
    public function chkUserSettings(int $loginId)
    {
        $userSettings = DB::table('user_settings')->where('user_id', $loginId)->first();
        $result = $userSettings ? $userSettings->comment_privacy : false;

        return $result;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function usersTagged()
    {
        return $this->belongsToMany(User::class, 'feed_tags', 'feed_id', 'user_id');
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getPageName($id)
    {
        $timeline = Timeline::where('id', $id)->first();
        $result = $timeline ? $timeline->username : false;

        return $result;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deletePageReport($id)
    {
        $timelineReport = DB::table('timeline_reports')->where('id', $id)->delete();
        $result = $timelineReport ? true : false;

        return $result;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteManageReport($id)
    {
        $feedReport = DB::table('feed_reports')->where('id', $id)->delete();

        $result = $feedReport ? true : false;

        return $result;
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
    /**
     * public function likes()
     * {
     * return $this->hasMany(Like::class);
     * }
     **/

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
