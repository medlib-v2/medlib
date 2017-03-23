<?php

namespace Medlib\Models;

use Carbon\Carbon;
use Medlib\Models\Like;
use Medlib\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
      'follows'
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
    public function comments()
    {
        return $this->belongsTo(Comment::class);
    }
    **/

    /**
     * A feed belongs to a Comment.
     * @return mixed
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest()->where('parent_id', null);
    }

    public function shared()
    {
        return $this->belongsToMany(User::class, 'feed_shares', 'feed_id', 'user_id');
    }

    public function images()
    {
        return $this->belongsToMany(Media::class, 'feed_media', 'feed_id', 'media_id');
    }

    public function users_posts()
    {
        return $this->belongsToMany(User::class, 'feeds', 'id', 'user_id');
    }

    public function managePostReport($post_id, $user_id)
    {
        $post_report = DB::table('feed_reports')->insert(['feed_id' => $post_id, 'reporter_id' => $user_id, 'status' => 'pending', 'created_at' => Carbon::now()]);

        $result = $post_report ? true : false;

        return $result;
    }

    public function checkReports($post_id)
    {
        $post_report = DB::table('feed_reports')->where('feed_id', $post_id)->first();

        $result = $post_report ? true : false;

        return $result;
    }

    public function postsLiked()
    {
        $result = DB::table('feed_likes')->get();

        return $result;
    }

    public function postsReported()
    {
        $result = DB::table('feed_reports')->get();

        return $result;
    }

    public function postShared()
    {
        $result = DB::table('feed_shares')->get();

        return $result;
    }

    public function chkUserFollower($login_id, $post_user_id)
    {
        $followers = DB::table('followers')->where('follower_id', $post_user_id)->where('followee_id', $login_id)->where('status', '=', 'approved')->first();

        if ($followers) {
            $userSettings = DB::table('user_settings')->where('user_id', $login_id)->first();
            $result = $userSettings ? $userSettings->comment_privacy : false;

            return $result;
        }
    }

    public function chkUserSettings($login_id)
    {
        $userSettings = DB::table('user_settings')->where('user_id', $login_id)->first();
        $result = $userSettings ? $userSettings->comment_privacy : false;

        return $result;
    }

    public function usersTagged()
    {
        return $this->belongsToMany(User::class, 'feed_tags', 'feed_id', 'user_id');
    }

    public function getPageName($id)
    {
        $timeline = Timeline::where('id', $id)->first();
        $result = $timeline ? $timeline->username : false;

        return $result;
    }

    public function deletePageReport($id)
    {
        $timeline_report = DB::table('timeline_reports')->where('id', $id)->delete();
        $result = $timeline_report ? true : false;

        return $result;
    }

    public function deleteManageReport($id)
    {
        $post_report = DB::table('feed_reports')->where('id', $id)->delete();

        $result = $post_report ? true : false;

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
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
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
