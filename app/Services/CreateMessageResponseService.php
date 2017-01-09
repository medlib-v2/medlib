<?php

namespace Medlib\Services;

use Medlib\Models\MessageResponse;
use Medlib\Repositories\User\UserRepository;
use Medlib\Repositories\Message\MessageRepository;

class CreateMessageResponseService extends Service
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
     * @var int
     */
    public $message_id;

    /**
     * @var Object
     */
    public $current_user;

    /**
     * Create a new command instance.
     *
     * @param $receiver_id
     * @param $body
     * @param $sender_id
     * @param $sender_profile_image
     * @param $sender_name
     * @param $message_id
     * @param $current_user
     */
    public function __construct($receiver_id, $body, $sender_id, $sender_profile_image, $sender_name, $message_id, $current_user)
    {
        parent::__construct();
        $this->receiver_id = $receiver_id;
        $this->body = $body;
        $this->sender_id = $sender_id;
        $this->sender_profile_image = $sender_profile_image;
        $this->sender_name = $sender_name;
        $this->message_id = $message_id;
        $this->current_user = $current_user;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository $userRepository
     * @param MessageRepository $messageRepository
     * @return void
     */
    public function handle(UserRepository $userRepository, MessageRepository $messageRepository)
    {
        $user = $userRepository->findById($this->receiver_id);
        $message = $messageRepository->findById($this->message_id);
        if (! $message->belongsToUser($this->receiver_id)) {
            $user->messages()->save($message);
        }
        if ($this->receiver_id == $this->sender_id) {
            $user_id_to_save = $message->getLastReceiverId();
            $message_response = MessageResponse::createMessageResponse(
                $this->body,
                $this->sender_id,
                $user_id_to_save,
                $this->sender_profile_image,
                $this->sender_name
            );
            $messageRepository->findById($this->message_id)->messageResponses()->save($message_response);
            $userRepository->findById($user_id_to_save)->messageResponses()->save($message_response);
        } else {
            $message_response = MessageResponse::createMessageResponse(
                $this->body,
                $this->sender_id,
                $this->receiver_id,
                $this->sender_profile_image,
                $this->sender_name
            );
            $messageRepository->findById($this->message_id)->messageResponses()->save($message_response);
            $user->messageResponses()->save($message_response);
        }
    }
}
