<?php

namespace Medlib\Http\Controllers\Dashboard;


use Medlib\Models\Feed;
use Medlib\Models\Setting;
use Medlib\Models\Timeline;
use Illuminate\Http\Request;
use Medlib\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use Medlib\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function index(Request $request)
    {
        $id = Auth::id();

        $timeline = Timeline::where('id', $id)->first();

        $trending_tags = trending_tags();
        $suggested_users = suggested_users();
        $suggested_groups = suggested_groups();
        $suggested_pages = suggested_pages();

        // Check for hashtag
        if ($request->hashtag) {
            $hashtag = '#'.$request->hashtag;
            $posts = Feed::where('body', 'like', "%{$hashtag}%")->latest()->paginate(Setting::get('items_page'));
        }
        else {
            // else show the normal feed
            $posts = Feed::whereIn('user_id', function ($query) use ($id) {
                $query->select('followee_id')
                    ->from('followers')
                    ->where('follower_id', $id);
            })->orWhere('user_id', $id)->latest()->paginate(Setting::get('items_page'));
        }

        if ($request->ajax() || $request->wantsJson()) {
            $responseHtml = '';
            foreach ($posts as $post) {
                $responseHtml .= view('timelines.partials.post', ['post' => $post, 'timeline' => $timeline, 'next_page_url' => $posts->appends(['ajax' => true, 'hashtag' => $request->hashtag])->nextPageUrl()])->render();
            }

            return $responseHtml;
        }

        $announcement = Announcement::find(Setting::get('announcement'));
        if ($announcement != null) {
            $chkIsExpire = $announcement->chkAnnouncementExpire($announcement->id);

            if ($chkIsExpire == 'notexpired') {
                $active_announcement = $announcement;
                if (!$announcement->users->contains($id)) {
                    $announcement->users()->attach($id);
                }
            }
        }

        $next_page_url = url('ajax/get-more-feed?page=2&ajax=true&hashtag='.$request->hashtag.'&username='.Auth::user()->username);

        //return $this->response(compact('timeline', 'posts', 'next_page_url', 'trending_tags', 'suggested_users', 'active_announcement', 'suggested_groups', 'suggested_pages'));

        //$theme->setTitle($timeline->name.' | '.Setting::get('site_title').' | '.Setting::get('site_tagline'));

        return view('dashboard.home', compact('timeline', 'posts', 'next_page_url', 'trending_tags', 'suggested_users', 'active_announcement', 'suggested_groups', 'suggested_pages'));
    }

    public function books()
    {
        return view('dashboard.books');
    }

    public function history()
    {
        return "History";
    }

    public function viewed()
    {
        return "Viewed";
    }
}
