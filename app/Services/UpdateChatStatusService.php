<?php

namespace Medlib\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateChatStatusService extends Service
{
    /**
     * @var boolean
     */
    protected $chatStatus;
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
        $this->chatStatus = $request->get('chat_status');
        $this->currentUser = Auth::user();
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $this->currentUser->updateChatStatus($this->chatStatus);
        $relatedToId = $this->currentUser->id;
        $friendsUserIds = $this->currentUser->friends()->where('onlinestatus', 1)->lists('requester_id');
        $friendsUserIds[] = $relatedToId;
        $this->client->updateChatStatusBar($friendsUserIds, 21, $relatedToId, $this->chatStatus);
    }
}
