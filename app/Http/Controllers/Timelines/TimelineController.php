<?php

namespace Medlib\Http\Controllers\Timelines;

use Medlib\Models\User;
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
      * @param  int $id
      *
      * @return Response
      */
     public function showTimeline($username)
     {
         //$admin_role_id = Role::where('name', '=', 'admin')->first();

         $posts = [];
         $timeline = Timeline::where('username', $username)->first();
         $user_post = '';

         if ($timeline == null) {
             return redirect('/');
         }

         $timeline_posts = $timeline->posts()->orderBy('created_at', 'desc')->with('comments')->paginate(10);

         foreach ($timeline_posts as $timeline_post) {
             //This is for filtering reported(flag) posts, displaying non flag posts
             if ($timeline_post->check_reports($timeline_post->id) == false) {
                 array_push($posts, $timeline_post);
             }
         }

         if ($timeline->type == 'user') {
             $follow_user_status = '';
             $timeline_post_privacy = '';
             $timeline_post = '';

             $user = User::where('timeline_id', $timeline['id'])->first();
             $own_pages = $user->own_pages();
             $own_groups = $user->own_groups();
             $liked_pages = $user->pageLikes()->get();
             $joined_groups = $user->groups()->get();
             //$joined_groups_count = $user->groups()->where('role_id', '!=', $admin_role_id->id)->where('status', '=', 'approved')->get()->count();
             $joined_groups_count = 1;
             $following_count = $user->following()->where('status', '=', 'approved')->get()->count();
             $followers_count = $user->followers()->where('status', '=', 'approved')->get()->count();
             $followRequests = $user->followers()->where('status', '=', 'pending')->get();

             $follow_user_status = DB::table('followers')->where('follower_id', '=', Auth::user()->id)
                 ->where('leader_id', '=', $user->id)->first();

             if ($follow_user_status) {
                 $follow_user_status = $follow_user_status->status;
             }

             $confirm_follow_setting = $user->getUserSettings(Auth::user()->id);
             $follow_confirm = $confirm_follow_setting->confirm_follow;

             //get user settings
             $live_user_settings = $user->getUserPrivacySettings(Auth::user()->id, $user->id);
             $privacy_settings = explode('-', $live_user_settings);
             $timeline_post = $privacy_settings[0];
             $user_post = $privacy_settings[1];
         } elseif ($timeline->type == 'page') {
             //$page = Page::where('timeline_id', '=', $timeline->id)->first();
             //$page_members = $page->members();
             $user_post = 'page';
         } elseif ($timeline->type == 'group') {
             //$group = Group::where('timeline_id', '=', $timeline->id)->first();
             //$group_members = $group->members();
             $user_post = 'group';
         }

         $next_page_url = url('ajax/get-more-posts?page=2&username='.$username);

         return view('users.timeline', compact('user', 'timeline', 'posts', 'liked_pages', 'timeline_type', 'page', 'group', 'next_page_url', 'joined_groups', 'follow_user_status', 'followRequests', 'following_count', 'followers_count', 'timeline_post', 'user_post', 'follow_confirm', 'joined_groups_count', 'own_pages', 'own_groups', 'group_members', 'page_members'))->render();
     }

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

    }

    public function showGlobalFeed(Request $request)
    {

    }

    public function changeAvatar(Request $request)
    {

    }

    public function changeCover(Request $request)
    {

    }

    public function createPost(Request $request)
    {

    }

    public function follow(Request $request)
    {
        $follow = User::where('timeline_id', '=', $request->timeline_id)->first();

        if (!$follow->followers->contains(Auth::user()->id)) {
            $follow->followers()->attach(Auth::user()->id, ['status' => 'approved']);

            $user = User::find(Auth::user()->id);
            $user_settings = $user->getUserSettings($follow->id);

            if ($user_settings && $user_settings->email_follow == 'yes') {
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
