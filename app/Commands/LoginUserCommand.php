<?php

namespace Medlib\Commands;

use Medlib\Commands\Command;
use Medlib\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Medlib\Realtime\Events as SocketClient;


class LoginUserCommand extends Command {

    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $remember;

    /**
     * @var Object
     */
    private $socketClient;

    /**
     * Create a new command instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request) {

        parent::__construct();

        $this->email = $request->get('email');
        $this->password = $request->get('password');
        $this->remember = $request->get('remember');
        $this->socketClient = new SocketClient;
    }

    /**
     * Execute the command.
     *
     * @return boolean
     */
    public function handle() {

        /**
         * Attempt to do the login
         */
        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {

            /**
             * Validation not successful, send back to form
             */
            Auth::logout();
            return Redirect::to('login')->with('error', trans('auth.login.failed'));

        }

        $user = Auth::user();

        /**
         * Check if account is active
         */

        if (! $user->userAccountIsActive() === true) {
            Auth::logout();
            return Redirect::guest('login')->with('info', 'Please activate your account to proceed.');
        }

        /**
         * validation successful!
         * redirect them to the secure section or whatever
         */
        $friendsUserIds = $user->friends()->where('onlinestatus', 1)->pluck('requester_id');
        $relatedToId = $user->id;
        $clientCode = 22;
        $message = true;
        //$this->socketClient->updateChatStatusBar($friendsUserIds, $clientCode, $relatedToId, $message);
        $user->updateOnlineStatus(1);
        return true;
    }

}