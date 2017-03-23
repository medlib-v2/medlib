<?php

namespace Medlib\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Medlib\Repositories\User\UserRepository;

class RemoveFriendService extends Service
{

    /**
     * @var string
     */
    protected $username;

    /**
     * @var \Medlib\Models\User
     */
    protected $currentUser;

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

        $this->currentUser = Auth::user();
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

        $this->currentUser->finishFriendshipWith($otherUser->id);

        $otherUser->finishFriendshipWith($this->currentUser->id);

        /**
         * $this->client->updateChatListFriendRemoved($otherUser->id, 24, $this->currentUser->id, $otherUser->friends()->count());
         * $this->currentUser->friends()->count();
         */
        return true;
    }
}
