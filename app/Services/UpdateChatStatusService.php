<?php

namespace Medlib\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateChatStatusService extends Service
{
    /**
     * @var boolean
     */
    protected $chat_status;
    /**
     * @var Object
     */
    protected $currentUser;

    /**
     * Create a new command instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->chat_status = $request->get('chat_status');
        $this->currentUser = Auth::user();
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $this->currentUser->updateChatStatus($this->chat_status);
        $related_to_id = $this->currentUser->id;
        $friends_user_ids = $this->currentUser->friends()->where('onlinestatus', 1)->lists('requester_id');
        $friends_user_ids[] = $related_to_id;
        $this->client->updateChatStatusBar($friends_user_ids, 21, $related_to_id, $this->chat_status);
    }
}
