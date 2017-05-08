<?php

namespace Medlib\Http\Controllers\Timelines;

use Medlib\Models\User;
use Medlib\Models\Page;
use Medlib\Models\Group;
use Medlib\Models\Role;
use Medlib\Models\Setting;
use Medlib\Models\Timeline;
use Illuminate\Http\Request;
use Alaouy\Youtube\Facades\Youtube;
use Illuminate\Support\Facades\Auth;
use Medlib\Http\Controllers\Controller;
use Medlib\Repositories\TimelineRepository;
use Medlib\Http\Requests\CreateTimelineRequest;
use Medlib\Http\Requests\UpdateTimelineRequest;
use Prettus\Repository\Criteria\RequestCriteria;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;

/**
 * Suppress all rules containing "unused" in this
 * class TimelineController
 *
 * @SuppressWarnings("unused")
 */
class TimelineController extends Controller
{
    /**
     * @var TimelineRepository
     */
    private $timelineRepository;

    public function __construct(TimelineRepository $timelineRepository)
    {
        $this->timelineRepository = $timelineRepository;
    }

    /**
     * Display a listing of the Timeline.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->timelineRepository->pushCriteria(new RequestCriteria($request));
        $this->timelineRepository->pushCriteria(new LimitOffsetCriteria($request));
        $timelines = $this->timelineRepository->all();

        //$timelines->toArray();
        return view('timelines.index')
            ->with('timelines', $timelines);
    }

    /**
     * Show the form for creating a new Timeline.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('timelines.create');
    }

    /**
     * Store a newly created Timeline in storage.
     *
     * @param CreateTimelineRequest $request
     *
     * @return Response
     */
    public function store(CreateTimelineRequest $request)
    {
        $input = $request->all();

        $timeline = $this->timelineRepository->create($input);

        return redirect(route('timelines.index'));
    }

    public function show($id)
    {
        $timeline = $this->timelineRepository->findWithoutFail($id);

        if (empty($timeline)) {
            return redirect(route('timelines.index'))->withErrors('Timeline not found');
        }

        return view('timelines.show')->with('timeline', $timeline);
    }

    /**
     * Show the form for editing the specified Timeline.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        $timeline = $this->timelineRepository->findWithoutFail($id);

        if (empty($timeline)) {
            return redirect(route('timelines.index'))->withErrors('Timeline not found');
        }

        return view('timelines.edit')->with('timeline', $timeline);
    }

    /**
     * Update the specified Timeline in storage.
     *
     * @param int                   $id
     * @param UpdateTimelineRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|Response
     */
    public function update($id, UpdateTimelineRequest $request)
    {
        $timeline = $this->timelineRepository->findWithoutFail($id);

        if (empty($timeline)) {
            return redirect(route('timelines.index'))->withErrors('Timeline not found');
        }

        $timeline = $this->timelineRepository->update($request->all(), $id);

        return redirect(route('timelines.index'))->with('success', 'Timeline updated successfully.');
    }


    /**
     * Remove the specified Timeline from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|Response
     */
    public function destroy($id)
    {
        $timeline = $this->timelineRepository->findWithoutFail($id);

        if (empty($timeline)) {
            return redirect(route('timelines.index'))->withErrors('Timeline not found');
        }

        $this->timelineRepository->delete($id);

        return redirect(route('timelines.index'))->with('success', 'Timeline deleted successfully.');
    }

    /**
     * Display the specified Timeline.
     *
     * @param  string $username
     *
     * @return Response
     */
    public function showTimeline($username)
    {
        $adminRoleId = Role::where('name', '=', 'admin')->first();

        $posts = [];
        $timeline = Timeline::where('username', $username)->first();
        $userFeed = '';

        if ($timeline == null) {
            return redirect('/');
        }

        $timelineFeeds = $timeline->posts()->orderBy('created_at', 'desc')->with('comments')->paginate(10);

        foreach ($timelineFeeds as $timelineFeed) {
            //This is for filtering reported(flag) posts, displaying non flag posts
            if ($timelineFeed->check_reports($timelineFeed->id) == false) {
                array_push($posts, $timelineFeed);
            }
        }

        if ($timeline->type == 'user') {
            $followUserStatus = '';
            $timelineFeedPrivacy = '';
            $timelineFeed = '';

            $user = User::where('timeline_id', $timeline['id'])->first();
            $ownPages = $user->ownPages();
            $ownGroups = $user->ownGroups();
            $likedPages = $user->pageLikes()->get();
            $joinedGroups = $user->groups()->get();
            $joinedGroupsCount = $user->groups()->where('role_id', '!=', $adminRoleId->id)->where('status', '=', 'approved')->get()->count();
            //$joinedGroupsCount = 1;
            $followingCount = $user->following()->where('status', '=', 'approved')->get()->count();
            $followersCount = $user->followers()->where('status', '=', 'approved')->get()->count();
            $followRequests = $user->followers()->where('status', '=', 'pending')->get();

            $followUserStatus = DB::table('followers')->where('follower_id', '=', Auth::user()->id)
                ->where('leader_id', '=', $user->id)->first();

            if ($followUserStatus) {
                $followUserStatus = $followUserStatus->status;
            }

            $confirmFollowSetting = $user->getUserSettings(Auth::user()->id);
            $followConfirm = $confirmFollowSetting->confirm_follow;

            //get user settings
            $liveUserSettings = $user->getUserPrivacySettings(Auth::user()->id, $user->id);
            $privacySettings = explode('-', $liveUserSettings);
            $timelineFeed = $privacySettings[0];
            $userFeed = $privacySettings[1];
        } elseif ($timeline->type == 'page') {
            $page = Page::where('timeline_id', '=', $timeline->id)->first();
            $pageMembers = $page->members();
            $userFeed = 'page';
        } elseif ($timeline->type == 'group') {
            $group = Group::where('timeline_id', '=', $timeline->id)->first();
            $groupMembers = $group->members();
            $userFeed = 'group';
        }

        $nextPageUrl = url('ajax/get-more-posts?page=2&username='.$username);

        return view('users.timeline', compact('user', 'timeline', 'posts', 'likedPages', 'timeline_type', 'page', 'group', 'nextPageUrl', 'joinedGroups', 'followUserStatus', 'followRequests', 'followingCount', 'followersCount', 'timelineFeed', 'userFeed', 'followConfirm', 'joinedGroupsCount', 'ownPages', 'ownGroups', 'groupMembers', 'pageMembers'))->render();
    }

    /**
     * @param Request $request
     * @return string
     */
    public function getMorePosts(Request $request)
    {
        $timeline = Timeline::where('username', $request->username)->first();

        $posts = $timeline->posts()->orderBy('created_at', 'desc')->with('comments')->paginate(Setting::get('items_page'));


        $responseHtml = '';
        foreach ($posts as $post) {
            $responseHtml .= view('timelines.partials.post', ['post' => $post, 'timeline' => $timeline, 'next_page_url' => $posts->appends(['username' => $request->username])->nextPageUrl()])->render();
        }

        return $responseHtml;
    }

    public function showFeed(Request $request)
    {
        dd($request);
    }

    public function showGlobalFeed(Request $request)
    {
        dd($request);
    }

    public function changeAvatar(Request $request)
    {
        dd($request);
    }

    public function changeCover(Request $request)
    {
        dd($request);
    }

    public function createPost(Request $request)
    {
        dd($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function follow(Request $request)
    {
        $follow = User::where('timeline_id', '=', $request->timeline_id)->first();

        if (!$follow->followers->contains(Auth::user()->id)) {
            $follow->followers()->attach(Auth::user()->id, ['status' => 'approved']);

            $user = User::find(Auth::user()->id);
            $userSettings = $user->getUserSettings($follow->id);

            if ($userSettings && $userSettings->email_follow == 'yes') {
                /**
                Mail::send('emails.followmail', ['user' => $user, 'follow' => $follow], function ($m) use ($user, $follow) {
                $m->from(Setting::get('noreply_email'), Setting::get('site_name'));
                $m->to($follow->email, $follow->name)->subject($user->name.' '.'follows you');
                });
                 **/
            }

            //Notify the user for follow here

            return response()->json(['status' => '200', 'followed' => true, 'message' => 'successfully followed']);
        } else {
            $follow->followers()->detach([Auth::user()->id]);

            //Notify the user for follow here

            return response()->json(['status' => '200', 'followed' => false, 'message' => 'successfully unFollowed']);
        }
    }

    public function getYoutubeVideo(Request $request)
    {
        $videoId = Youtube::parseVidFromURL($request->youtube_source);

        $video = Youtube::getVideoInfo($videoId);

        $videoData = [
            'id'     => $video->id,
            'title'  => $video->snippet->title,
            'iframe' => $video->player->embedHtml,
        ];

        return response()->json(['status' => '200', 'message' => $videoData]);
    }
}
