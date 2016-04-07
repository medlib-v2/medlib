<?php

namespace Medlib\Http\Controllers\Feeds;

use Illuminate\Http\Request;

use Medlib\Models\Feed;
use Medlib\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Medlib\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Medlib\Repositories\Feed\FeedRepository;


class FeedController extends Controller {

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
     *
     *
     */
    public function __construct()
    {
        $this->currentUser = Auth::user();

        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param FeedRepository $feedRepository
     * @return mixed
     */
    public function index(FeedRepository $feedRepository)
    {
        $user = $this->currentUser;

        $feeds = $feedRepository->getPublishedByUserAndFriends($user);

        $friendsUserIds[] = $user->id;

        $feedsCount = Feed::getTotalCountFeedsForUser($friendsUserIds);
        
        return view('feeds.index', compact('user', 'feeds', 'feedsCount'));
    }

    /**
     *  Display more feeds via ajax.
     *
     * @param Request $request
     * @param FeedRepository $feedRepository
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function more(Request $request, FeedRepository $feedRepository)
    {
        $validator = Validator::make($request->all(), ['skipQty' => 'required']);

        if($validator->fails()) return abort(403);

        $feeds = $feedRepository->getPublishedByUserAndFriendsAjax($this->currentUser, $request->skipQty);

        return response()->json(['feeds' => $feeds]);
    }

    /**
     * Store a newly created feed in storage.
     *
     * @param Request $request
     * @return \Illuminate\Support\Facades\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), ['body'	=> 'required']);

        if($validator->fails()) return response()->json(['response' => 'failed']);

        $feed = Feed::publish($request->get('body'), $this->currentUser->getFirstName(), $this->currentUser->getAvatar());

        Auth::user()->feeds()->save($feed);

        return response()->json([
            'response' => 'success',
            'userAvatar' => $feed->getAvatarPublisher(),
            'userFirstname' => $feed->getFirstNamePublisher(),
            'feedBody' => $feed->getContent() ]);
    }
}
