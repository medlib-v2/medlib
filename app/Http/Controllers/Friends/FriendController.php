<?php

namespace Medlib\Http\Controllers\Friends;

use Medlib\Models\User;
use Illuminate\Http\Request;
use Medlib\Models\FriendRequest;
use Illuminate\Support\Facades\Auth;
use Medlib\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Medlib\Commands\RemoveFriendCommand;
use Illuminate\Support\Facades\Validator;
use Medlib\Repositories\User\UserRepository;

class FriendController extends Controller {


    public function __construct() {

        $this->currentUser = Auth::user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(UserRepository $repository) {

        $user = $this->currentUser;

        $friends = $repository->findByIdWithFriends($user->id);

        return view('friends.index', compact('friends', 'user'));
    }

    /**
     * Store a newly created friend
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request, UserRepository $repository){

        dd($request);

        $validator = Validator::make($request->all(), ['username' => 'required']);

        if($validator->fails())
        {
            return response()->json(['response' => 'failed', 'message' => 'Something went wrong please try again.'], 500);
        }
        else
        {
            $friend = User::whereUsername($request->get('username'))->first();

            $this->currentUser->createFriendShipWith($friend->id);

            $repository->findByUsername($friend->getUsername())->createFriendShipWith($this->currentUser->id);

            FriendRequest::where('user_id', $this->currentUser->id)->where('requester_id', $friend->id)->delete();

            $friendRequestCount = $this->currentUser->friendRequests()->count();

            return response()->json(['response' => 'success', 'count' => $friendRequestCount, 'message' => 'Friend request accepted.']);
        }

    }



    /**
     * Terminate friendship between 2 users.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function destroy(Request $request) {

        $validator = Validator::make($request->all(), ['username' => 'required']);

        if($validator->fails())
        {
            return response()->json(['response' => 'failed', 'message' => 'Something went wrong please try again.']);
        }
        else
        {
            $this->dispatchFrom(RemoveFriendCommand::class, $request, ['username' => $request->username]);

            $friendsCount = $this->currentUser->friends()->count();

            return response()->json(['response' => 'success', 'count' => $friendsCount, 'message' => 'This friend has been removed']);
        }
    }

}
