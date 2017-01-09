<?php

namespace Medlib\Services;

use Illuminate\Support\Facades\Auth;

class SendChatMessageService extends Service
{

    /**
     * @var int
     */
    protected $receiver_id;

    /**
     * @var string
     */
    protected $message;

    /**
     * Create a new command instance.
     *
     * @param int $receiver_id
     * @param string $message
     */
    public function __construct($receiver_id, $message)
    {
        parent::__construct();

        $this->receiver_id = $receiver_id;
        $this->message = $message;
    }

    /**
     * Execute the command.
     *
     * @return boolean
     */
    public function handle()
    {
        $sender_id = Auth::user()->id;
        $this->client->sendMessageTo($this->receiver_id, 23, $sender_id, $this->message);
        return true;
    }
}
