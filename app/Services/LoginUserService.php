<?php

namespace Medlib\Services;

use Illuminate\Http\Request;
use Medlib\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Response as IlluminateResponse;

class LoginUserService extends Service
{
    /**
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers, HttpResponseService;

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
     * @var Request
     */
    private $request;

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
        $this->request = $request;
    }

    /**
     * Execute the command.
     *
     * @return boolean|string|\Illuminate\Http\JsonResponse
     */
    public function handle()
    {
        $remember = ($this->remember ? true : false);
        $user = null;
        $nameoremail = null;
        $canLogin = false;

        if ($this->hasTooManyLoginAttempts($this->request)) {
            $this->fireLockoutEvent($this->request);
            $seconds = $this->limiter()->availableIn(
                $this->throttleKey($this->request)
            );
            return $this->responseWithError("Too many attempts. Try after $seconds seconds.", IlluminateResponse::HTTP_UNAUTHORIZED);
        }


        if (filter_var(($this->email), FILTER_VALIDATE_EMAIL)  == true) {
            $nameoremail = $this->email;
            $user = User::where('email', $this->email)->first();
        } else {
            $user = User::where('username', $this->email)->first();
            if ($user) {
                $nameoremail = $user->email;
            }
        }

        /**
         * Check if account is active
         */
        if (!is_null($user)) {
            if (! $user->userAccountIsActive() === true) {
                return ['error' => 'activate_account'];
            }
            $canLogin = true;
        } else {
            return ['error' => 'login_failed'];
        }

        try {
            /**
             * Attempt to do the login
             */
            if ($canLogin && $token = JWTAuth::attempt(['email' => $nameoremail, 'password' => $this->password])) {
                /**
                 * validation successful!
                 * redirect them to the secure section or whatever
                 */
                $this->clearLoginAttempts($this->request);
                $this->request->session()->regenerate();
                $friends_user_ids = $user->friends()->where('onlinestatus', 1)->pluck('requester_id')->toArray();
                $related_to_id = $user->id;
                $client_code = 22;
                $message = true;
                $this->client->updateChatStatusBar($friends_user_ids, $client_code, $related_to_id, $message);
                $user->updateOnlineStatus(1);
                return compact('token', 'user');
            } else {
                /**
                 * Validation not successful, send back to form
                 */
                //Auth::logout();
                $this->incrementLoginAttempts($this->request);
                return ['error' => 'invalid_credentials'];
            }

        } catch (JWTException $e) {
            Log::error($e);
            return ['error' => 'could_not_create_token', 'message' => $e->getMessage()];
        }
    }
}
