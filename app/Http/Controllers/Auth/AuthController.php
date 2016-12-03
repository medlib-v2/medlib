<?php

namespace Medlib\Http\Controllers\Auth;

use Exception;
use Carbon\Carbon;
use Medlib\Models\User;
use Illuminate\Http\Request;
use Medlib\Services\ProcessImage;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Medlib\Events\UserWasRegistered;
use Medlib\Commands\LoginUserCommand;
use Medlib\Commands\LogoutUserCommand;
use Medlib\Http\Controllers\Controller;
use Medlib\Commands\RegisterUserCommand;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Medlib\Http\Requests\RegisterUserRequest;
use Medlib\Commands\RegisterSocialUserCommand;
use Medlib\Http\Requests\CreateSessionRequest;
use Medlib\Events\UserRegistrationConfirmation;
use Laravel\Socialite\Two\User as UserProvider;


/**
 * @Middleware("guest", except={"logout"})
 */
class AuthController extends Controller {

    /**
     * Show the Login Page
     *
     * @Get("/login", as="auth.login")
     * @Middleware("guest")
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLogin() {
        return View::make('auth.login');
    }

    /**
     * @Post("/login")
     * @Middleware("guest")
     *
     * @param CreateSessionRequest $request
     * @return mixed
     */
    public function doLogin(CreateSessionRequest $request) {

        $response = Bus::dispatch(new LoginUserCommand($request));

        if($response) return redirect()->route('home');

        return redirect()->back()->with('error', trans('auth.login.failed'));
    }

    /**
     * Show the register page
     * @Get("/register", as="auth.register")
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

        $user_avatar = App::make(ProcessImage::class)->execute($request->file('profileimage'), 'avatars/', 200, 200);

        $date_of_birth = Carbon::createFromDate($request->get('year'), $request->get('month'), $request->get('day'))->toDateString();

        $request->merge([
            'date_of_birth' => $date_of_birth,
            'user_avatar' => $user_avatar,
            'confirmation_code' => self::generateToken()
        ]);

        Bus::dispatch(new RegisterUserCommand($request));

        return redirect()->route('home')->with('info', trans('auth.account_created_success'))
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
     * LogOut the user.
     *
     * @Get("/logout", as="auth.logout")
     * @Middleware("auth")
     *
     * @return Redirect
     */
    public function doLogout() {
        $response = Bus::dispatch(new LogoutUserCommand());
        if(!$response) return redirect()->route('home');

        /**
         * $request = new Request(['username' => Auth::user()->getUsername]);
         * $response = Bus::dispatch(LogoutUserCommand::class, $request, ['username' => Auth::user()->getUsername]);
         * #if($response) response()->json(['response' => 'success']);
         * Auth::logout();
         * return redirect()->route('home');
         **/
    }

    /**
     * @Get("/verify", as="auth.verify")
     * @Middleware("guest")
     *
     * @param string $confirmation_code
     * @return mixed
     *
     */
    public function doVerify($confirmation_code) {

        if(!$confirmation_code) {
            return redirect()->route('home')->with('error', trans('auth.validation.need_validation_code'));
        }

        /**
         * $user = User::where('confirmation_code', '=', $confirmation_code)->first();
         */
        $user = User::whereConfirmationCode($confirmation_code)->first();

        if (!$user)  {
            return redirect()->route('auth.login')->with('error', trans('auth.validation.validation_code_does_not_exist'));
        }

        $timestamp_one_hour_ago = Carbon::now();
        $created = new Carbon($user->updated_at);

        if($created->diff($timestamp_one_hour_ago)->days >= 1 OR $created->diffInHours($timestamp_one_hour_ago) >= 1) {
            $user->confirmation_code = self::generateToken();
            $user->save();

            //event(new UserWasRegistered($user));
            $job = (new UserWasRegistered($user))->delay(60);

            $this->dispatch($job);

            unset($user);
            return redirect()->route('auth.login')->with('error', trans('auth.validation.validation_code_has_expired'));
        }

        $user->user_active = true;
        $user->confirmation_code = null;
        $user->save();

        event(new UserRegistrationConfirmation($user));

        unset($user);

        return redirect()->route('auth.login')->with('success', trans('auth.validation.account_has_been_activated'));
    }

    /**
     * Generate the verification token.
     *
     * @return string
     */
    protected static function generateToken() {

        return str_random(64).config('app.key');
    }

    /**
     * Redirect the user to the social provider ie facebook/twitter etc
     *
     * @Get("/auth/{facebook}", as="auth.social")
     * @Middleware("guest")
     *
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToSocialProvider($provider)
    {
        /**
         * Check to see if the provider is supported, if not
         * redirect the user back to where they came from
         */
        if(!array_key_exists($provider, config('services'))) return redirect()->route('auth.login');

        return Socialite::driver($provider)->fields([
            'first_name',
            'last_name',
            'email',
            'gender',
            'birthday',
        ])->redirect();
    }

    /**
     * Handle the call back from social providers
     *
     * @param string $provider
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function handleSocialProviderCallback($provider, Request $request)
    {
        /**
         * Check to see if the provider is supported, if not
         * abort the signup
         */
        if(!array_key_exists($provider, config('services'))) redirect()->route('auth.login');

        $method = 'handle'.studly_case($provider . "Callback");

        if (method_exists($this, $method)) {
            return $this->{$method}($request);
        } else {
            return $this->handleMissingCallbackMethod();
        }

    }

    /**
     * Obtain the user information from Facebook.
     * Handle Facebook callback
     *
     * @param Request $request
     * @return Redirect
     */
    public function handleFacebookCallback(Request $request)
    {
        /**
         * Get the user information from facebook
         */
        try {
            $providerUser = Socialite::driver('facebook')->fields([
                'first_name',
                'last_name',
                'email',
                'gender',
                'birthday'
            ])->scopes([
                'email', 'user_birthday'
            ])->user();
        } catch (Exception $e) {

            return redirect()->route('auth.login')->with('error', 'Something went wrong or You have rejected the app!');
        }

        $authUser = $this->findOrCreateUser($providerUser, 'facebook_id');

        Auth::login($authUser, true);

        return redirect()->route('home');

    }

    /**
     * Obtain the user information from Twitter.
     * Handle Twitter callback
     *
     * @param Request $request
     * @return Redirect
     */
    public function handleTwitterCallback(Request $request)
    {
        /**
         * Get the user information from facebook
         */
        try {
            $providerUser = Socialite::driver('twitter')->fields([
                'first_name',
                'last_name',
                'email',
                'gender',
                'birthday'
            ])->scopes([
                'email', 'user_birthday'
            ])->user();
        } catch (Exception $e) {

            return redirect()->route('auth.login')->with('error', 'Something went wrong or You have rejected the app!');
        }

        $authUser = $this->findOrCreateUser($providerUser, 'twitter_id');

        Auth::login($authUser, true);

        return redirect()->route('home');

    }

    /**
     * Handle any missing call back methods
     */
    private function handleMissingCallbackMethod()
    {
        //
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param \Laravel\Socialite\Two\User $providerUser
     * @param string $provider
     * @return User
     */
    private function findOrCreateUser(UserProvider $providerUser, $provider)
    {
        $authUser = User::where($provider, $providerUser->id)->first();

        if ($authUser){
            return $authUser;
        }

        return RegisterSocialUserCommand::create([
            'email' => $providerUser->user['email'],
            'username' => $providerUser->name ?$providerUser->name : self::generateUsername($providerUser),
            'password' => '',
            'first_name' => $providerUser->user['first_name'],
            'last_name' => $providerUser->user['last_name'],
            'profession' => '',
            'location' => '',
            'date_of_birth' => '',
            'gender' => $providerUser->user['gender'],
            'facebook_id' => $providerUser->id,
            'user_avatar' => $providerUser->getAvatar(),
            'confirmation_code' => self::generateToken()
        ]);
    }

    /**
     * @param \Laravel\Socialite\Two\User $providerUser
     *
     * @return null|string
     */
    protected static function generateUsername(UserProvider $providerUser){
        $username = null;

        $username = substr(strtolower($providerUser->user['first_name']), 0, 1);
        $username .= "_";
        $username .= strtolower($providerUser->user['last_name']);

        return  $username;
    }
}