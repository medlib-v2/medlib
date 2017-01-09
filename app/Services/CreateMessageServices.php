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
     * @var string
     */
    public $sender_profile_image;

    /**
     * @var string
     */
    public $sender_name;

    /**
     * Create a new command instance.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct();

        $this->receiver_id = $request->get('receiver_id');
        $this->body = $request->get('body');
        $this->sender_id = $request->get('sender_id');
        $this->sender_profile_image = $request->get('sender_profile_image');
        $this->sender_name = $request->get('sender_name');
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
        $message = Message::createMessage($this->body, $this->sender_id, $this->sender_profile_image, $this->sender_name);

        $response = MessageResponse::createMessageResponse($this->body, $this->sender_id, $this->receiver_id, $this->sender_profile_image, $this->sender_name);

        $userRepository->findById($this->receiver_id)->messages()->save($message);

        $messageRepository->findById($message->id)->messageResponses()->save($response);
        
        $userRepository->findById($this->receiver_id)->messageResponses()->save($response);

        return true;
    }
}
