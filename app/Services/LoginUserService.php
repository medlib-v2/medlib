<?php

namespace Medlib\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Medlib\RealTime\Events as SocketClient;

class LoginUserService extends Service
{

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
     * Create a new command instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct();

        $this->email = $request->get('email');
        $this->password = $request->get('password');
        $this->remember = $request->get('remember');
    }

    /**
     * Execute the command.
     *
     * @return boolean
     */
    public function handle()
    {

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
        $friends_user_ids = $user->friends()->where('onlinestatus', 1)->pluck('requester_id');
        $related_to_id = $user->id;
        $client_code = 22;
        $message = true;
        $this->client->updateChatStatusBar($friends_user_ids, $client_code, $related_to_id, $message);
        $user->updateOnlineStatus(1);
        return true;
    }
}
