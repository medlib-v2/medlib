<?php

namespace Medlib\Services;

use Log;
use JWTAuth;
use Exception;
use Medlib\Models\User;
use Illuminate\Support\Facades\Auth;
use Medlib\RealTime\Events as SocketClient;

class LogoutUserService extends Service
{

    /**
     * @var User
     */
    public $user;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->user = Auth::user();
    }

    /**
     * Execute the command.
     *
     * @return boolean
     */
    public function handle()
    {
        $this->user->updateOnlineStatus(0);
        $friendsUserIds = $this->user->friends()->where('onlinestatus', 1)->pluck('requester_id')->toArray();
        $related_to_id = $this->user->id;

        $this->client->updateChatStatusBar($friendsUserIds, 22, $related_to_id, false);

        /**
        if ($token = JWTAuth::getToken()) {
            try {
                JWTAuth::invalidate($token);
            } catch (Exception $e) {
                Log::error($e);
            }
        }
        return response()->json();
        **/

        if ($token = JWTAuth::fromUser($this->user)) {
            try {
                JWTAuth::invalidate($token);
            } catch (Exception $e) {
                Log::error($e);
            }
        }

        Auth::logout();

        return Auth::check();
    }
}
