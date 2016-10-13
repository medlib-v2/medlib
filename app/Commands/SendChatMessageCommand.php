<?php

namespace Medlib\Commands;

use Medlib\Commands\Command;
use Medlib\Realtime\Chat as SocketClient;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\Auth;

class SendChatMessageCommand extends Command implements SelfHandling {

    /**
     * @var int
     */
    protected $receiverId;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var Object
     */
    protected $socketClient;

    /**
     * Create a new command instance.
     *
     * @param int $receiverId
     * @param string $message
     */
    public function __construct($receiverId, $message) {
        $this->receiverId = $receiverId;
        $this->message = $message;
        $this->socketClient = new SocketClient;
    }

    /**
     * Execute the command.
     *
     * @return boolean
     */
    public function handle() {
        $senderId = Auth::user()->id;
        $this->socketClient->sendMessageTo($this->receiverId, 23, $senderId, $this->message);
        return true;
    }
}