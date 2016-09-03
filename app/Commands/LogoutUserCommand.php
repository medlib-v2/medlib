<?php

namespace Medlib\Commands;

use Medlib\Models\User;
use Medlib\Commands\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Bus\SelfHandling;
use Medlib\Realtime\Events as SocketClient;

class LogoutUserCommand extends Command implements SelfHandling {

	/**
	 * @var User
	 */
	public $user;

	/**
	 * @var Object
	 */
	public $socketClient;

	/**
	 * Create a new command instance.
	 *
	 * @param int $username
	 */
	public function __construct($username) {
		$this->user = Auth::user();
		#$this->user = User::find($username);
		#$this->socketClient = new SocketClient;
	}

	/**
	 * Execute the command.
	 *
	 * @return boolean
	 */
	public function handle() {

		#$this->user->updateOnlineStatus(0);
		#$friendsUserIds = $this->user->friends()->where('onlinestatus', 1)->lists('requester_id');
		#$relatedToId = $this->user->id;
		#$this->socketClient->updateChatStatusBar($friendsUserIds, 22, $relatedToId, false);
		Auth::logout();

		return Auth::check();
	}

}
