<?php

namespace Medlib\Http\Controllers\Friends;

use Medlib\Models\User;
use Illuminate\Http\Request;
use Medlib\Models\FriendRequest;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Auth;
use Medlib\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Medlib\Repositories\User\UserRepository;
use Medlib\Commands\CreateFriendRequestCommand;
use Illuminate\Pagination\LengthAwarePaginator;
use Medlib\Repositories\FriendRequest\FriendRequestRepository;

class FriendRequestController extends Controller {

    /**
     *  @var \Medlib\Models\User
     */
    protected $currentUser;

    /**
     * Create a new instance of FriendRequestController.
     */
    public function __construct() {

        $this->middleware('auth');

        $this->currentUser = Auth::user();
    }

    /**
     * Display a listing of the resource.
     *
     * @param FriendRequestRepository $friendRequest
     * @param UserRepository $repository
     * @return mixed
     */
    public function index(FriendRequestRepository $friendRequest, UserRepository $repository) {
        $user = $this->currentUser;

        $requesterIds = $friendRequest->getIdsThatSentRequestToCurrentUser($user->id);

        $userObjects = $repository->findManyById($requesterIds);

        $usersWhoRequested = new LengthAwarePaginator($userObjects, count($userObjects), 10, 1, ['path' => '/friends/requests']);

        return view('friends.friend-requests', compact('usersWhoRequested'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created Friend Request.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function store(Request $request) {

        $validator = Validator::make($request->all(), ['username' => 'required']);

        if($validator->fails()) {
            return response()->json(['response' => 'failed', 'message' => 'Something went wrong please try again.'], 500);
        }
        else  {
            Bus::dispatchFrom(CreateFriendRequestCommand::class, $request, [ 'requestedName'	=> $request->get('username') ]);

            return response()->json(['response' => 'success', 'message' => 'Friend request submitted']);

        }
    }

    /**
     * Remove a friend request.
     *
     * @param Request $request
     *
     *
     * @return mixed
     */
    public function destroy(Request $request) {

        $user = $this->currentUser;

        $validator = Validator::make($request->all(), ['username' => 'required']);

        if($validator->fails())
        {
            return response()->json(['response' => 'failed', 'message' => 'Something went wrong please try again.']);
        }
        else
        {
            $friend = User::whereUsername($request->get('username'))->first();

            FriendRequest::where('user_id', $user->id)->where('requester_id', $friend->id)->delete();

            $friendRequestCount = $this->currentUser->friendRequests()->count();

            return response()->json(['response' => 'success', 'count' => $friendRequestCount, 'message' => 'friend request removed']);
        }

    }

}
