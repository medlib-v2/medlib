<?php

namespace Medlib\Http\Controllers\Feeds;

use Medlib\Models\Feed;
use Medlib\Models\Like;
use Medlib\Models\User;
use Illuminate\Http\Request;
use Medlib\Services\ProcessImage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Medlib\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Medlib\Repositories\Feed\FeedRepository;
use Medlib\Repositories\User\UserRepository;
use Medlib\Repositories\Comment\CommentRepository;

class FeedController extends Controller
{

    /**
     * var FeedRepository
     */
    protected $feedRepository;

    /**
     * @var \Medlib\Models\User;
     */
    private $currentUser;

    /**
     * Create a new instance of FeedController.
     */
    public function __construct()
    {
        $this->currentUser = Auth::user();
    }

    /**
     * Display a listing of the resource.
     *
     * @param $username
     * @param FeedRepository $feedRepository
     * @param UserRepository $userRepository
     * @param CommentRepository $commentRepository
     *
     * @return mixed
     */
    public function index($username, FeedRepository $feedRepository, UserRepository $userRepository, CommentRepository $commentRepository)
    {
        $this->currentUser = Auth::user();
        
        if ($username == $this->currentUser->getUsername()) {
            $user = $this->currentUser;

            return $this->getFeedAndComment($user, $feedRepository, $commentRepository);
        } else {
            $user = $userRepository->findByUsername($username);
            if ($user == null) {
                return $this->setStatusCode(422)->response(['response' => 'failed', 'message' => "User does not exist $username"]);
            }
            return $this->getFeedAndComment($user, $feedRepository, $commentRepository);
        }
    }

    /**
     * Display more feeds via ajax.
     *
     * @param Request $request
     * @param FeedRepository $feedRepository
     * @param CommentRepository $commentRepository
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function more(Request $request, FeedRepository $feedRepository, CommentRepository $commentRepository)
    {
        $validator = Validator::make($request->all(), ['skipQty' => 'required']);

        if ($validator->fails()) {
            return abort(403);
        }

        $this->currentUser = Auth::user();

        $feeds = $feedRepository->getPublishedByUserAndFriendsAjax($this->currentUser, $request->skipQty);

        return Response::json(['response' => 'success', 'feeds' => $feeds]);
    }

    /**
     * Store a newly created feed in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['body'    => 'required']);

        if ($validator->fails()) {
            return Response::json([$validator->messages()], 400);
        }

        $this->currentUser = Auth::user();

        $file = $request->file('image');
        $videoUrl = $request->input('videoUrl');
        $location = $request->input('location');

        if (isset($file) && !empty($file)) {
            $imgfile = ['image' => $file];
            $rules = ['image' => 'required|mimes:jpeg,jpg,png|image'];
            $validator = Validator::make($imgfile, $rules);

            if ($validator->fails()) {
                return Response::json([$validator->messages()], 400);
            }

            if ($request->file('image')->isValid()) {
                $destinationPath = Config::get('image.upload_path').'images';

                $pathImage = App::make(ProcessImage::class)->upload($file, $destinationPath);

                return $this->storeFeed($request->get('body'), $this->currentUser->getUsername(), $this->currentUser->getAvatar(), $pathImage, null, null);
            } else {
                return $this->setStatusCode(400)->response(['response' => 'error', 'message' => 'Uploaded file is not valid']);
            }
        }

        if (isset($videoUrl) && !empty($videoUrl)) {
            if (!self::validateUrl($videoUrl)) {
                return $this->setStatusCode(400)->response(['response' => 'error', 'message' => 'Url not valid']);
            }

            return $this->storeFeed($request->get('body'), $this->currentUser->getUsername(), $this->currentUser->getAvatar(), null, $videoUrl, null);
        }

        if (isset($location) && !empty($location)) {
            die(print_r($location));
        }

        return $this->storeFeed($request->get('body'), $this->currentUser->getUsername(), $this->currentUser->getAvatar(), null, null, null);
    }

    /**
     * @param $username
     * @param $status_id
     */
    public function like($username, $status_id)
    {
        $post = Feed::find($status_id);

        $like =  Like::create([
            'user_id' => Auth::id(),
            'feed_id' => $post->id
        ]);

        return Like::find($like->id);
    }

    public function unlike($username, $status_id)
    {
        $post = Feed::find($status_id);

        $like = Like::where('user_id', Auth::id())
            ->where('feed_id', $post->id)
            ->first();

        $like->delete();

        return $like->id;
    }

    /**
     * @param $username
     * @param $status_id
     */
    public function comment($username, $status_id)
    {
        dd($username, $status_id);
    }
    /**
     * Get all feed by user
     *
     * @param User $user
     * @param FeedRepository $feedRepository
     * @param CommentRepository $commentRepository
     *
     * @return mixed
     */
    protected function getFeedAndComment(User $user, FeedRepository $feedRepository, CommentRepository $commentRepository)
    {
        $feeds = $feedRepository->getPublishedByUserAndFriends($user);

        //$friendsUserIds[] = $user->id;
        //$feedsCount = Feed::getTotalCountFeedsForUser($friendsUserIds);

        return $this->response(compact('feeds'));

        /**
        if (request()->ajax()) {
            return response()->json(['response' => 'success', compact('user', 'feeds', 'feedsCount')], 200);
        }
        return view('feeds.index', compact('user', 'feeds'));
        **/
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
     * @return Response
     */
    protected function storeFeed($body, $poster_username, $poster_profile_image, $image_url = null, $video_url = null, $location = null)
    {
        $feed = Feed::publish($body, $poster_username, $poster_profile_image, $image_url, $video_url, $location);

        Auth::user()->feeds()->save($feed);

        return $this->response([
            'response' => 'success',
            'feed_id' => $feed->getFeedId(),
            'user_avatar' => $feed->getAvatarPublisher(),
            'user_name' => $feed->getUsernamePublisher(),
            'image_url' => $feed->getImagePath(),
            'video_url' => $feed->getVideoPath(),
            'feed_body' => $feed->getContent(),
            'publish_at' => $feed->getPublishAt()]);
    }

    /**
     * Validator Url Youtube and Vimeo
     *
     * @param $value
     * @return bool
     */
    protected static function validateUrl($value)
    {

        //$pattern = "/^http:\/\/(?:www\.)?(?:youtube.com|youtu.be)\/(?:watch\?(?=.*v=([\w\-]+))(?:\S+)?|([\w\-]+))$/";
        $regYoutube = "/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/";
        $vimeo = "/^.*(vimeo.com/)((channels/[A-z]+/)|(groups/[A-z]+/videos/))?([0-9]+)/;";

        return (preg_match($regYoutube, $value) || preg_match($vimeo, $value)) ? true : false;
    }
}
