<?php

namespace Medlib\Commands;

use Medlib\Commands\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Medlib\Realtime\Events as SocketClient;
use Illuminate\Contracts\Bus\SelfHandling;


class LoginUserCommand extends Command implements SelfHandling {

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
     * @param string $email
     * @param string $password
     * @param boolean $remember
     */
    public function __construct($email, $password, $remember = false) {

        $this->email = $email;
        $this->password = $password;
        $this->remember = $remember;
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
        if (! $user->userAccountIsActive() == true) {
            Auth::logout();
            return Redirect::guest('login')->with('info', 'Please activate your account to proceed.');
        }

        /**
         * validation successful!
         * redirect them to the secure section or whatever
         */
        $friendsUserIds = $user->friends()->where('onlinestatus', 1)->lists('requester_id');
        $relatedToId = $user->id;
        $clientCode = 22;
        $message = true;
        //$this->socketClient->updateChatStatusBar($friendsUserIds, $clientCode, $relatedToId, $message);
        $user->updateOnlineStatus(1);
        return true;
    }

}