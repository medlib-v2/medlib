<?php

namespace Medlib\Services;

use Illuminate\Support\Facades\Auth;
use Medlib\Http\Requests\SendMessageChatRequest;

class SendChatMessageService extends Service
{
    /**
     * @var int
     */
    protected $receiverId;

    /**
     * @var string
     */
    protected $message;

    /**
     * Create a new command instance.
     *
     * @param SendMessageChatRequest $request
     * @internal param int $receiver_id
     * @internal param string $message
     */
    public function __construct(SendMessageChatRequest $request)
    {
        parent::__construct();

        $this->receiverId = $request->get('receiver_id');
        $this->message = $request->get('message');
    }

    /**
     * Execute the command.
     *
     * @return boolean
     */
    public function handle()
    {
        $senderId = Auth::id();
        $this->client->sendMessageTo($this->receiverId, 23, $senderId, $this->message);
        return true;
    }
}
