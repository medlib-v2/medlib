<?php

namespace Medlib\Services;

use Medlib\Models\Message;
use Medlib\Repositories\User\UserRepository;
use Medlib\Http\Requests\CreateMessageRequest;
use Medlib\Repositories\Message\MessageRepository;

class CreateMessageService extends Service
{
    /**
     * @var int
     */
    public $receiverId;

    /**
     * @var string
     */
    public $body;

    /**
     * @var int
     */
    public $senderId;

    /**
     * @var int
     */
    public $conversationId;

    /**
     * Create a new command instance.
     * @param \Medlib\Http\Requests\CreateMessageRequest $request
     */
    public function __construct(CreateMessageRequest $request)
    {
        parent::__construct();

        $this->body = $request->get('body');
        $this->senderId = $request->get('sender_id');
        $this->receiverId = $request->get('receiver_id');
        $this->conversationId = $request->get('conversation_id');
    }

    /**
     * Execute the command.
     *
     * @param UserRepository $userRepository
     * @param MessageRepository $messageRepository
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function handle(UserRepository $userRepository, MessageRepository $messageRepository)
    {
        $message = Message::createMessage($this->body, $this->senderId, $this->receiverId, $this->conversationId);

        $sender = $userRepository->findById($this->senderId);
        $receiver = $userRepository->findById($this->receiverId);

        $sender->messages()->save($message);
        $receiver->messages()->save($message);

        return  $messageRepository->findById($message->id);
    }
}
