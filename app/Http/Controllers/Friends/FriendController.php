<?php

namespace Medlib\Http\Controllers\Friends;

use Medlib\Models\User;
use Medlib\Models\FriendRequest;
use Illuminate\Support\Facades\Auth;
use Medlib\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Medlib\Services\RemoveFriendService;
use Medlib\Http\Requests\FriendUserRequest;
use Medlib\Repositories\User\UserRepository;

class FriendController extends Controller
{

    /**
     * @var \Medlib\Models\User;
     */
    private $currentUser;

    /**
     * FriendController constructor.
     */
    public function __construct()
    {
        $this->currentUser = Auth::user();
    }

    /**
     * Display a listing of the resource.
     *
     * @param UserRepository $repository
     *
     * @return Response
     */
    public function index(UserRepository $repository)
    {
        $user = $this->currentUser = Auth::user();

        $friends = $repository->findByIdWithFriends($user->id);

        return view('friends.index', compact('friends', 'user'));
    }

    /**
     * Store a newly created friend
     *
     * @param FriendUserRequest $request
     * @param UserRepository $repository
     *
     * @return Response
     */
    public function store(FriendUserRequest $request, UserRepository $repository)
    {
        $this->currentUser = Auth::user();

        $friend = User::whereUsername($request->get('username'))->first();

        $this->currentUser->createFriendShipWith($friend->id);

        $repository->findByUsername($friend->getUsername())->createFriendShipWith($this->currentUser->id);

        FriendRequest::where('user_id', $this->currentUser->id)->where('requester_id', $friend->id)->delete();

        $friendRequestCount = $this->currentUser->friendRequests()->count();

        return response()->json(['response' => 'success', 'count' => $friendRequestCount, 'message' => 'Friend request accepted.'], 200);
    }



    /**
     * Terminate friendship between 2 users.
     *
     * @param FriendUserRequest $request
     *
     * @return Response
     */
    public function destroy(FriendUserRequest $request)
    {
        $this->currentUser = Auth::user();

        $this->dispatch(new RemoveFriendService($request));

        $friendsCount = $this->currentUser->friends()->count();

        return response()->json(['response' => 'success', 'count' => $friendsCount, 'message' => 'This friend has been removed'], 200);
    }
}
