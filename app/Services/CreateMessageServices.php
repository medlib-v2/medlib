<?php

namespace Medlib\Services;

use Medlib\Models\Message;
use Illuminate\Http\Request;
use Medlib\Models\MessageResponse;
use Medlib\Repositories\User\UserRepository;
use Medlib\Repositories\Message\MessageRepository;

class CreateMessageService extends Service
{
    /**
     * @var int
     */
    public $receiver_id;

    /**
     * @var string
     */
    public $body;

    /**
     * @var int
     */
    public $sender_id;

    /**
     * Create a new command instance.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct();

        $this->body = $request->get('body');
        $this->sender_id = $request->get('sender_id');
        $this->receiver_id = $request->get('receiver_id');
    }

    /**
     * Execute the command.
     *
     * @param UserRepository $userRepository
     * @param MessageRepository $messageRepository
     *
     * @return Boolean
     */
    public function handle(UserRepository $userRepository, MessageRepository $messageRepository)
    {
        $message = Message::createMessage($this->body, $this->sender_id, $this->receiver_id);

        $response = MessageResponse::createMessageResponse($this->body, $this->sender_id, $this->receiver_id);

        $userRepository->findById($this->receiver_id)->messages()->save($message);

        $messageRepository->findById($message->id)->messageResponses()->save($response);
        
        $userRepository->findById($this->receiver_id)->messageResponses()->save($response);

        return true;
    }
}
