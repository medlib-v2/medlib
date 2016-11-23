<?php

namespace Medlib\Commands;

use Medlib\Models\User;
use Medlib\Commands\Command;
use Medlib\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;
use Medlib\Realtime\Events as SocketClient;

class LogoutUserCommand extends Command {

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
	 */
	public function __construct() {

        parent::__construct();

		$this->user = Auth::user();
		$this->socketClient = new SocketClient;
	}

	/**
	 * Execute the command.
	 *
	 * @return boolean
	 */
	public function handle() {

		$this->user->updateOnlineStatus(0);
		//$friendsUserIds = $this->user->friends()->where('onlinestatus', 1)->pluck('requester_id');
		//$relatedToId = $this->user->id;
		//$this->socketClient->updateChatStatusBar($friendsUserIds, 22, $relatedToId, false);
		Auth::logout();

		return Auth::check();
	}

}
