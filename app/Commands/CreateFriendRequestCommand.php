<?php

namespace Medlib\Commands;


use Medlib\Commands\Command;
use Medlib\Models\FriendRequest;
use Illuminate\Support\Facades\Auth;
use Medlib\Events\FriendRequestWasSent;
use Illuminate\Contracts\Bus\SelfHandling;
use Medlib\Repositories\User\UserRepository;

class CreateFriendRequestCommand extends Command implements SelfHandling
{

    /**
     *  @var int
     */
    protected $requestedId;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($requestedId)
    {
        $this->requestedId = $requestedId;
    }
    /**
     * Execute the command.
     *
     * @param UserRepository $userRepository
     *
     * @return void
     */
    public function handle(UserRepository $userRepository)
    {
        $requestedUser = $userRepository->findById($this->requestedId);

        $requesterUser = Auth::user();

        $friendRequest = FriendRequest::prepareFriendRequest($requesterUser->id);

        $requestedUser->friendRequests()->save($friendRequest);

        event(new FriendRequestWasSent($requestedUser, $requesterUser));

        return true;
    }
}
