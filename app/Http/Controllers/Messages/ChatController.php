<?php

namespace Medlib\Http\Controllers\Messages;

use Medlib\Http\Controllers\Controller;
use Medlib\Services\SendChatMessageService;
use Medlib\Repositories\User\UserRepository;
use Medlib\Http\Requests\SendMessageChatRequest;
use Illuminate\Http\Response as IlluminateResponse;

class ChatController extends Controller
{


    /**
     * Send chat message to another user.
     *
     * @param \Medlib\Http\Requests\SendMessageChatRequest $request
     * @param \Medlib\Repositories\User\UserRepository $userRepository
     *
     * @return mixed
     */
    public function sendMessage(SendMessageChatRequest $request, UserRepository $userRepository)
    {
        $this->dispatch(new SendChatMessageService($request, $userRepository));

        return response()->json(['response' => 'success', 'availableToChat' => $userRepository->findById($request->receiverId)->chatstatus]);
    }
}
