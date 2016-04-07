<?php

namespace Medlib\Http\Controllers\Messages;

use Medlib\Http\Controllers\Controller;
use Medlib\Commands\SendChatMessageCommand;
use Medlib\Repositories\User\UserRepository;
use Medlib\Http\Requests\SendMessageChatRequest;

class ChatController extends Controller {


    /**
     * Send chat message to another user.
     *
     * @param \Medlib\Http\Requests\SendMessageChatRequest $request
     * @param \Medlib\Repositories\User\UserRepository $userRepository
     *
     * @return mixed
     */
    public function sendMessage(SendMessageChatRequest $request, UserRepository $userRepository) {

        $this->dispatchFrom(SendChatMessageCommand::class, $request);

        return response()->json(['response' => 'success', 'availableToChat' => $userRepository->findById($request->receiverId)->chatstatus]);

        /**
        if($validator->fails()) {
            if($validator->fails()) return abort(403);
        }
        else {}
        */

    }
}
