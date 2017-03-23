<?php

namespace Medlib\Http\Controllers\Timelines;

use Medlib\Models\Role;
use Medlib\Models\User;
use Medlib\Models\Feed;
use Medlib\Models\Like;
use Medlib\Models\Timeline;
use Medlib\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Medlib\Services\CreateFeedService;
use Medlib\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Medlib\Http\Requests\CreateFeedRequest;
use Medlib\Repositories\Feed\FeedRepository;
use Medlib\Repositories\User\UserRepository;
use Medlib\Repositories\Page\PageRepository;
use Medlib\Repositories\Group\GroupRepository;
use Illuminate\Http\Response as IlluminateResponse;

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
     * @param PageRepository $pageRepository
     * @param GroupRepository $groupRepository
     * @return mixed
     * @internal param GroupRepository $groupRepositor
     */
    public function index($username, FeedRepository $feedRepository, UserRepository $userRepository, PageRepository $pageRepository, GroupRepository $groupRepository )
    {
        $posts = [];
        $user_post = '';
        $this->currentUser = Auth::user();

        if ($username == $this->currentUser->getUsername()) {
            $user = $this->currentUser;
        } else {
            $user = $userRepository->findByUsername($username);
            if ($user == null) {
                return $this->responseWithError(['message' => "User does not exist with nickname $username"], IlluminateResponse::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        $admin_role_id = Role::where('name', '=', 'admin')->first();
        $timeline = Timeline::where('id', '=', $user->timeline_id)->first();

        if ($timeline == null) {
            return $this->responseWithError(['message' => "Timeline does not exist for this $username"], IlluminateResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $timeline_posts = $feedRepository->getPublishedByTimelineOrByUser($timeline, $user);

        foreach ($timeline_posts as $timeline_post) {
            /**
             * This is for filtering reported(flag) posts, displaying non flag posts
             */
            if ($timeline_post->checkReports($timeline_post->id) == false) {
                array_push($posts, $timeline_post);
            }
        }

        if ($timeline->type == 'user') {
            $follow_user_status = '';
            $timeline_post_privacy = '';
            $timeline_post = '';

            $own_pages = $user->ownPages();
            $own_groups = $user->ownGroups();
            $liked_pages = $user->pageLikes()->get();
            $joined_groups = $user->groups()->get();
            $joined_groups_count = $user->groups()->where('role_id', '!=', $admin_role_id->id)->where('status', '=', 'approved')->get()->count();
            $following_count = $user->following()->where('status', '=', 'approved')->get()->count();
            $followers_count = $user->followers()->where('status', '=', 'approved')->get()->count();
            $followRequests = $user->followers()->where('status', '=', 'pending')->get();

            $follow_user_status = Follower::where('follower_id', '=', Auth::user()->id)
                ->where('followee_id', '=', $user->id)->first();

            if ($follow_user_status) {
                $follow_user_status = $follow_user_status->status;
            }

            $confirm_follow_setting = $user->getUserSettings(Auth::user()->id);
            $follow_confirm = $confirm_follow_setting->confirm_follow;

            /**
             * get user settings
             */
            $live_user_settings = $user->getUserPrivacySettings(Auth::user()->id, $user->id);
            $privacy_settings = explode('-', $live_user_settings);
            $timeline_post = $privacy_settings[0];
            $user_post = $privacy_settings[1];
        } elseif ($timeline->type == 'page') {
            $page = $pageRepository->findByIdWithTimeline($timeline->id);
            $page_members = $page->members();
            $user_post = 'page';
        } elseif ($timeline->type == 'group') {
            $group = $groupRepository->findByIdWithTimeline($timeline->id);
            $group_members = $group->members();
            $user_post = 'group';
        }

        $next_page_url = route('user.feeds.more', ['page'=> 2, 'username' => $username]);

        return $this->responseWithSuccess(compact(
            'user',
            'timeline',
            'posts',
            'liked_pages',
            'timeline_type',
            'page', 'group',
            'next_page_url',
            'joined_groups',
            'follow_user_status',
            'followRequests',
            'following_count',
            'followers_count',
            'timeline_post',
            'user_post',
            'follow_confirm',
            'joined_groups_count',
            'own_pages',
            'own_groups',
            'group_members',
            'page_members'
        ));
    }

    /**
     * Display more feeds via ajax.
     *
     * @param Request $request
     * @param FeedRepository $feedRepository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function more(Request $request, FeedRepository $feedRepository)
    {
        $validator = Validator::make($request->all(), ['nextPage' => 'required']);

        if ($validator->fails()) {
            return abort(403);
        }

        $this->currentUser = Auth::user();

        $feeds = $feedRepository->getPublishedByUserAndFriendsAjax($this->currentUser, $request->get('nextPage'));

        return $this->responseWithSuccess($feeds, IlluminateResponse::HTTP_FORBIDDEN);
    }

    /**
     * Store a newly created feed in storage.
     *
     * @param CreateFeedRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateFeedRequest $request)
    {
        $response = $this->dispatch(new CreateFeedService($request));

        return $this->responseWithSuccess($response);
    }

    /**
     * @param $username
     * @param $status_id
     * @return mixed
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
     * @param Request $request
     */
    public function comment($username, Request $request)
    {
        dd($username, $request);

        /**
        $comment = Comment::create([
            'post_id'     => $request->post_id,
            'description' => $request->description,
            'user_id'     => Auth::id(),
            'parent_id'   => $request->comment_id,
        ]);

        $post = Post::where('id', $request->post_id)->first();
        $posted_user = $post->user;

        if ($comment) {
            if (Auth::user()->id != $post->user_id) {
                //Notify the user for comment on his/her post
                Notification::create(['user_id' => $post->user_id, 'post_id' => $request->post_id, 'notified_by' => Auth::user()->id, 'description' => Auth::user()->name.' commented on your post', 'type' => 'comment_post']);
            }

            $theme = Theme::uses(Setting::get('current_theme', 'default'))->layout('ajax');
            if ($request->comment_id) {
                $reply = $comment;
                $main_comment = Comment::find($reply->parent_id);
                $main_comment_user = $main_comment->user;

                $user = User::find(Auth::user()->id);
                $user_settings = $user->getUserSettings($main_comment_user->id);
                if ($user_settings && $user_settings->email_reply_comment == 'yes') {
                    Mail::send('emails.commentreply_mail', ['user' => $user, 'main_comment_user' => $main_comment_user], function ($m) use ($user, $main_comment_user) {
                        $m->from(Setting::get('noreply_email'), Setting::get('site_name'));
                        $m->to($main_comment_user->email, $main_comment_user->name)->subject('New reply to your comment');
                    });
                }
                $postHtml = $theme->scope('timeline/reply', compact('reply', 'post'))->render();
            } else {
                $user = User::find(Auth::user()->id);
                $user_settings = $user->getUserSettings($posted_user->id);
                if ($user_settings && $user_settings->email_comment_post == 'yes') {
                    Mail::send('emails.commentmail', ['user' => $user, 'posted_user' => $posted_user], function ($m) use ($user, $posted_user) {
                        $m->from(Setting::get('noreply_email'), Setting::get('site_name'));
                        $m->to($posted_user->email, $posted_user->name)->subject('New comment to your post');
                    });
                }

                $postHtml = $theme->scope('timeline/comment', compact('comment', 'post'))->render();
            }
        }

        return response()->json(['status' => '200', 'comment_id' => $comment->id, 'data' => $postHtml]);
        **/
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
