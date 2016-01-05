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
     *  @var string
     */
    protected $requestedName;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($requestedName)
    {
        $this->requestedName = $requestedName;
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
        $requestedUser = $userRepository->findByUsername($this->requestedName);

        $requesterUser = Auth::user();

        $friendRequest = FriendRequest::prepareFriendRequest($requesterUser->id);

        $requestedUser->friendRequests()->save($friendRequest);

        event(new FriendRequestWasSent($requestedUser, $requesterUser));

        return true;
    }
}
