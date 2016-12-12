<?php

namespace Medlib\Commands;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Medlib\Repositories\User\UserRepository;
use Medlib\Realtime\Events as SocketClient;

class RemoveFriendCommand extends Command
{

    /**
     * @var int
     */
    protected $username;

    /**
     * @var Object
     */
    protected $socketClient;


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

        #$this->socketClient = new SocketClient;
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

        $currentUser->finishFriendshipWith($this->username);

        $otherUser->finishFriendshipWith(Auth::user()->id);

        #$this->socketClient->updateChatListFriendRemoved($otherUser->id, 24, $currentUser->id, $otherUser->friends()->count());

        return true;
    }
}
