<?php

namespace Medlib\Http\Controllers\Friends;

use Medlib\Models\User;
use Medlib\Models\Timeline;
use Illuminate\Support\Facades\Auth;
use Medlib\Http\Controllers\Controller;
use Medlib\Services\RemoveFriendService;
use Medlib\Http\Requests\FriendUserRequest;
use Medlib\Repositories\User\UserRepository;
use Medlib\Services\FriendRequestAcceptedService;
use Illuminate\Http\Response as IlluminateResponse;

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(UserRepository $repository)
    {
        $user = Auth::user();

        $friends = $repository->findByIdWithFriends($user->id);

        return $this->responseWithSuccess(compact('friends', 'user'), IlluminateResponse::HTTP_OK);
    }

    /**
     * Store a newly created friend
     *
     * @param FriendUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FriendUserRequest $request)
    {
        $friendRequestCount = $this->dispatch(new FriendRequestAcceptedService($request));

        return $this->responseWithSuccess([
            'count' => $friendRequestCount,
            'message' => 'Friend request accepted.'
        ], IlluminateResponse::HTTP_OK);
    }

    public function friends($username)
    {
        $user = Timeline::where('username', '=' ,$username)->first();

        if ($user == null) {
            $user = User::where('username', '=', $username)->first();

            if ($user == null) {
                return $this->responseWithError('User does not exist '.$username, IlluminateResponse::HTTP_NOT_FOUND);
            }
        }
        return $this->responseWithError($user->friends);
    }

    /**
     * Terminate friendship between 2 users.
     *
     * @param FriendUserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(FriendUserRequest $request)
    {
        $friendsCount = $this->dispatch(new RemoveFriendService($request));

        return $this->responseWithSuccess([
            'count' => $friendsCount,
            'message' => 'This friend has been removed'
        ], IlluminateResponse::HTTP_OK);
    }
}
