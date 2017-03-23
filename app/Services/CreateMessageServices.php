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
     * @var int
     */
    public $conversation_id;

    /**
     * Create a new command instance.
     * @param \Medlib\Http\Requests\CreateMessageRequest $request
     */
    public function __construct(CreateMessageRequest $request)
    {
        parent::__construct();

        $this->body = $request->get('body');
        $this->sender_id = $request->get('sender_id');
        $this->receiver_id = $request->get('receiver_id');
        $this->conversation_id = $request->get('conversation_id');
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
        $message = Message::createMessage($this->body, $this->sender_id, $this->receiver_id, $this->conversation_id);

        $sender = $userRepository->findById($this->sender_id);
        $receiver = $userRepository->findById($this->receiver_id);

        $sender->messages()->save($message);
        $receiver->messages()->save($message);

        return  $messageRepository->findById($message->id);
    }
}
