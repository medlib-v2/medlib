<?php

namespace Medlib\Http\Controllers\Friends;

use Medlib\Models\User;
use Medlib\Models\FriendRequest;
use Illuminate\Support\Facades\Auth;
use Medlib\Http\Controllers\Controller;
use Medlib\Http\Requests\FriendUserRequest;
use Medlib\Repositories\User\UserRepository;
use Medlib\Services\CreateFriendRequestService;
use Illuminate\Pagination\LengthAwarePaginator;
use Medlib\Repositories\FriendRequest\FriendRequestRepository;
use Illuminate\Http\Response as IlluminateResponse;

class FriendRequestController extends Controller
{

    /**
     *  @var \Medlib\Models\User
     */
    protected $currentUser;

    /**
     * Display a listing of the resource.
     *
     * @param FriendRequestRepository $friendRequest
     * @param UserRepository $repository
     * @return mixed
     */
    public function index(FriendRequestRepository $friendRequest, UserRepository $repository)
    {
        $this->currentUser = Auth::user();

        $requesterIds = $friendRequest->getIdsThatSentRequestToCurrentUser($this->currentUser->id);
        $userObjects = $repository->findManyById($requesterIds);

        $usersWhoRequested = new LengthAwarePaginator($userObjects, count($userObjects), 10, 1, ['path' => '/friends/requests']);

        return $this->responseWithError(compact('usersWhoRequested'), IlluminateResponse::HTTP_OK);
        //return view('friends.friend-requests', compact('usersWhoRequested'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created Friend Request.
     *
     * @param FriendUserRequest $request
     *
     * @return mixed
     */
    public function store(FriendUserRequest $request)
    {
        $this->dispatch(new CreateFriendRequestService($request));

        return $this->responseWithSuccess([
            'message' => 'Friend request submitted'
        ], IlluminateResponse::HTTP_OK);
    }

    /**
     * Remove a friend request.
     *
     * @param FriendUserRequest $request
     *
     *
     * @return mixed
     */
    public function destroy(FriendUserRequest $request)
    {
        $this->currentUser = Auth::user();

        $friend = User::whereUsername($request->get('username'))->first();

        FriendRequest::where('user_id', $this->currentUser->id)->where('requester_id', $friend->id)->delete();

        $friendRequestCount = $this->currentUser->friendRequests()->count();

        /**
         * return response()->json(['response' => 'success', 'count' => $friendRequestCount, 'message' => 'friend request removed']);
         *
         */
        return $this->responseWithSuccess([
            'count' => $friendRequestCount,
            'message' => 'friend request removed'
        ], IlluminateResponse::HTTP_OK);
    }
}
