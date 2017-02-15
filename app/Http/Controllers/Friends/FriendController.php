<?php

namespace Medlib\Http\Controllers\Friends;

use Illuminate\Support\Facades\Auth;
use Medlib\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Medlib\Services\FriendRequestAcceptedService;
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
        $user = Auth::user();

        $friends = $repository->findByIdWithFriends($user->id);

        return view('friends.index', compact('friends', 'user'));
    }

    /**
     * Store a newly created friend
     *
     * @param FriendUserRequest $request
     * @return Response
     */
    public function store(FriendUserRequest $request)
    {
        $friendRequestCount = $this->dispatch(new FriendRequestAcceptedService($request));

        return $this->setStatusCode(200)->response(['response' => 'success', 'count' => $friendRequestCount, 'message' => 'Friend request accepted.']);
    }

    public function friends($username)
    {

        return $this->response(Auth::user()->friends);
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
        $friendsCount = $this->dispatch(new RemoveFriendService($request));

        return response()->json(['response' => 'success', 'count' => $friendsCount, 'message' => 'This friend has been removed'], 200);
    }
}
