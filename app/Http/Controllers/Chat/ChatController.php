<?php

namespace Medlib\Http\Controllers\Chat;

use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Medlib\Http\Controllers\Controller;
use Medlib\Http\Requests\ChatStatusRequest;
use Medlib\Services\SendChatMessageService;
use Medlib\Repositories\User\UserRepository;
use Medlib\Services\UpdateChatStatusService;
use Medlib\Http\Requests\SendMessageChatRequest;

class ChatController extends Controller
{
    public function __construct()
    {
        Carbon::setToStringFormat(DateTime::ISO8601);
    }

    /**
     * @param ChatStatusRequest $request
     */
    public function update(ChatStatusRequest $request)
    {
        $this->dispatch(new UpdateChatStatusService($request));
    }

    /**
     * @param SendMessageChatRequest $request
     * @param UserRepository $userRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function message(SendMessageChatRequest $request, UserRepository $userRepository)
    {
        $this->dispatch(new SendChatMessageService($request));
        return $this->response(['response' => 'success', 'available_to_chat' => $userRepository->findById($request->receiver_id)->chatstatus]);
    }

    public function messages(UserRepository $userRepository)
    {
        $messages = $userRepository->findByIdWithMessages(Auth::id());
        dd('ici', $messages);
        $this->response($messages);
    }
}