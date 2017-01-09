<?php

namespace Medlib\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Medlib\Repositories\User\UserRepository;

class RemoveFriendService extends Service
{

    /**
     * @var int
     */
    protected $username;

    /**
     * Create a new command instance.
     *
     * @param Request $request
     *
     */
    public function __construct(Request $request)
    {
        parent::__construct();

        $this->username = $request->get('username');
    }

    /**
     * Execute the command.
     *
     * @param \Medlib\Repositories\User\UserRepository $userRepository
     *
     * @return boolean
     */
    public function handle(UserRepository $userRepository)
    {
        $otherUser = $userRepository->findByUsername($this->username);

        $currentUser = Auth::user();

        $currentUser->finishFriendshipWith($otherUser->id);

        $otherUser->finishFriendshipWith($currentUser->id);

        $this->client->updateChatListFriendRemoved($otherUser->id, 24, $currentUser->id, $otherUser->friends()->count());

        return true;
    }
}
