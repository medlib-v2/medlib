<?php

namespace Medlib\Http\Controllers\Auth;


use Carbon\Carbon;
use Medlib\Models\User;
use Medlib\Services\ProcessImage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Medlib\Events\UserWasRegistered;
use Medlib\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Medlib\Realtime\Events as SocketClient;
use Medlib\Http\Requests\RegisterUserRequest;
use Medlib\Http\Requests\CreateSessionRequest;


use Medlib\Commands\LoginUserCommand;

/**
 * @Middleware("guest", except={"logout"})
 */
class AuthController extends Controller {

    /**
     * @var \Medlib\Realtime\Events
     */
    private $socketClient;

    /**
     * Create a new command instance.
     */
    public function __construct() {
        $this->socketClient = new SocketClient;
    }

    /**
     * Show the Login Page
     *
     * @Get("login", as="auth.login")
     * @Middleware("guest")
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLogin() {
        return View::make('auth.login');
    }

    /**
     * @param CreateSessionRequest $request
     * @return mixed
     */
    public function doLogin(CreateSessionRequest $request) {

        /**
         * $response = $this->dispatch(LoginUserCommand::class, $request);
         * if($response) return Redirect::route('home');
         * return Redirect::back()->with('error', trans('auth.login.failed'));
         */

        /**
         * Set the remember me cookie if the user check the box
         * $remember = ($request->has('remember')) ? true : false;
         *
         * create our user data for the authentication
         */
        $userdata = [
            'email'     => $request->get('email'),
            'password'  => $request->get('password')
        ];

        /**
         * Attempt to do the login
         */
        if (! Auth::attempt($userdata, $request->has('remember'))) {
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
        return Redirect::route('home');
    }

    /**
     * Show the Register Page
     * @Get("register", as="auth.register")
     * @Middleware("guest")
     *
     * @return mixed
     */
    public function showRegister() {
        return View::make('auth.register');
    }

    /**
     * Register a new user in database end sending a confirmation email
     * @Post("register")
     * @Middleware("guest")
     *
     * @param RegisterUserRequest $request
     * @return mixed
     */
    public function doRegister(RegisterUserRequest $request) {

        $userProfileImage = App::make(ProcessImage::class)->execute($request->file('profileimage'), 'avatars/', 180, 180);

        $date_of_birth = Carbon::createFromDate($request->get('year'), $request->get('month'), $request->get('day'))->toDateString();

        $user = User::create([
            'email' => $request->get('email'),
            'username' => $request->get('username'),
            'password' => Hash::make($request->get('password')),
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'profession' => $request->get('profession'),
            'location' => "",
            'date_of_birth' => $date_of_birth,
            'gender' => $request->get('gender'),
            'user_active' => false,
            'account_type' => false,
            'user_avatar' => $userProfileImage,
            'confirmation_code' => self::generateToken()
        ]);

        event(new UserWasRegistered($user));

        unset($user);

        return Redirect::route('home')->with('info', trans('auth.account_created_success'))
            ->with('success', trans('auth.email_was_sent'));

    }

    /**
     * @Get("reg_birthday", as="auth.reg_birthday")
     * @Middleware("guest")
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reg_birthday() {
        return View::make('auth.reg_birthday');
    }

    /**
     * Log the user out.
     *
     * @Get("logout", as="auth.logout")
     * @Middleware("auth")
     *
     * @return Redirect
     */
    public function doLogout() {
        Auth::logout();
        return Redirect::route('home');
    }

    /**
     * @Get("verify", as="auth.verify")
     * @Middleware("guest")
     *
     * @param string $confirmation_code
     * @return mixed
     *
     */
    public function doVerify(string $confirmation_code) {

        if(!$confirmation_code) {
            return Redirect::route('home')->with('error', trans('auth.validation.need_validation_code'));
        }

        /**
         * $user = User::where('confirmation_code', '=', $confirmation_code)->first();
         */
        $user = User::whereConfirmationCode($confirmation_code)->first();

        if (!$user)  {
            return Redirect::route('auth.login')->with('error', trans('auth.validation.validation_code_does_not_exist'));
        }

        $timestamp_one_hour_ago = Carbon::now();
        $created = new Carbon($user->updated_at);

        if($created->diff($timestamp_one_hour_ago)->days >= 1 OR $created->diffInHours($timestamp_one_hour_ago) >= 1) {
            $user->confirmation_code = self::generateToken();
            $user->save();

            event(new UserWasRegistered($user));

            unset($user);
            return Redirect::route('auth.login')->with('error', trans('auth.validation.validation_code_has_expired'));
        }

        $user->user_active = true;
        $user->confirmation_code = null;
        $user->save();

        unset($user);

        return Redirect::route('auth.login')->with('success', trans('auth.validation.account_has_been_activated'));
    }

    /**
     * Generate the verification token.
     *
     * @return string
     */
    protected static function generateToken() {

        return str_random(64).config('app.key');
    }
}