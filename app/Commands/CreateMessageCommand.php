<?php

namespace Medlib\Commands;

use Medlib\Models\Message;
use Medlib\Commands\Command;
use Medlib\Models\MessageResponse;
use Medlib\Repositories\User\UserRepository;
use Medlib\Repositories\Message\MessageRepository;

class CreateMessageCommand extends Command {

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
	 * @var string
	 */
	public $senderProfileImage;
	/**
	 * @var string
	 */
	public $senderName;


	/**
	 * Create a new command instance.
	 */
	public function __construct($receiverId, $body, $senderId, $senderProfileImage, $senderName) {

        parent::__construct();

		$this->receiverId = $receiverId;
		$this->body = $body;
		$this->senderId = $senderId;
		$this->senderProfileImage = $senderProfileImage;
		$this->senderName = $senderName;
	}

	/**
	 * Execute the command.
	 *
	 * @param UserRepository $userRepository
	 * @param MessageRepository $messageRepository
	 *
	 * @return boolean
	 */
	public function handle(UserRepository $userRepository, MessageRepository $messageRepository) {
		
		$message = Message::createMessage($this->body, $this->senderId, $this->senderProfileImage, $this->senderName);

		$response = MessageResponse::createMessageResponse($this->body, $this->senderId, $this->receiverId, $this->senderProfileImage, $this->senderName);

		$userRepository->findById($this->receiverId)->messages()->save($message);

		$messageRepository->findById($message->id)->messageResponses()->save($response);
		
		$userRepository->findById($this->receiverId)->messageResponses()->save($response);

		return true;
	}

}
