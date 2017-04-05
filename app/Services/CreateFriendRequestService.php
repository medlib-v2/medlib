<?php

namespace Medlib\Services;

use Illuminate\Http\Request;
use Medlib\Models\FriendRequest;
use Illuminate\Support\Facades\Auth;
use Medlib\Events\FriendRequestWasSent;
use Medlib\Repositories\User\UserRepository;

class CreateFriendRequestService extends Service
{
    /**
     *  @var string
     */
    protected $requestedName;

    /**
     * Create a new command instance.
     * @param Request $request
     *
     */
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->requestedName = $request->get('username');
    }

    /**
     * Execute the command.
     *
     * @param UserRepository $userRepository
     *
     * @return boolean
     */
    public function handle(UserRepository $userRepository)
    {
        $requestedUser = $userRepository->findByUsername($this->requestedName);
        $requesterUser = Auth::user();
        $friendRequest = FriendRequest::prepareFriendRequest($requesterUser->id);
        $requestedUser->friendRequests()->save($friendRequest);

        event(new FriendRequestWasSent($requestedUser, $requesterUser));

        return true;
    }
}
