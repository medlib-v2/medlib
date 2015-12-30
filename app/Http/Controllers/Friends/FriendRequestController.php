<?php

namespace Medlib\Http\Controllers\Friends;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Medlib\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Medlib\Repositories\User\UserRepository;
use Medlib\Commands\CreateFriendRequestCommand;
use Illuminate\Pagination\LengthAwarePaginator;
use Medlib\Repositories\FriendRequest\FriendRequestRepository;

class FriendRequestController extends Controller
{

    /**
     *  @var User
     */
    protected $currentUser;

    /**
     * Create a new instance of FriendRequestController.
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->currentUser = Auth::user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FriendRequestRepository $friendRequest, UserRepository $repository)
    {
        $user = $this->currentUser;

        $requesterIds = $friendRequest->getIdsThatSentRequestToCurrentUser($user->id);

        $userObjects = $repository->findManyById($requesterIds);

        $usersWhoRequested = new LengthAwarePaginator($userObjects, count($userObjects), 10, 1, ['path' => '/friend-requests']);

        return view('friends.friend-requests', compact('usersWhoRequested'));
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
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        return response()->json(compact($request), 500);

        $validator = Validator::make($request->all(), ['username' => 'required']);

        if($validator->fails())
        {
            return response()->json(['response' => 'failed', 'message' => 'Something went wrong please try again.']);
        }
        else
        {
            $this->dispatchFrom(CreateFriendRequestCommand::class, $request, [ 'requestedId'	=> $request->userId ]);

            return response()->json(['response' => 'success', 'message' => 'Friend request submitted']);

        }
    }

}
