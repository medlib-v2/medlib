<?php

namespace Medlib\Services;

use Illuminate\Support\Facades\Auth;
use Medlib\Http\Requests\SendMessageChatRequest;

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
     * @param SendMessageChatRequest $request
     * @internal param int $receiver_id
     * @internal param string $message
     */
    public function __construct(SendMessageChatRequest $request)
    {
        parent::__construct();

        $this->receiver_id = $request->get('receiver_id');
        $this->message = $request->get('message');
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
