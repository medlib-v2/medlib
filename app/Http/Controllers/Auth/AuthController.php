<?php

namespace Medlib\Http\Controllers\Auth;


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
use Medlib\Realtime\Events as SocketClient;
use Medlib\Http\Requests\RegisterUserRequest;
use Medlib\Http\Requests\CreateSessionRequest;
use Medlib\Events\UserRegistrationConfirmation;

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

        if($response) return Redirect::route('home');

        return Redirect::back()->with('error', trans('auth.login.failed'));
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
     * LogOut the user.
     *
     * @Get("/logout", as="auth.logout")
     * @Middleware("auth")
     *
     * @return Redirect
     */
    public function doLogout() {
        #$request = new Request(['username' => Auth::user()->getUsername]);
        #$response = Bus::dispatch(LogoutUserCommand::class, $request, ['username' => Auth::user()->getUsername]);
        #if($response) response()->json(['response' => 'success']);
        Auth::logout();
        return Redirect::route('home');
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

            //event(new UserWasRegistered($user));
            $job = (new UserWasRegistered($user))->delay(60);

            $this->dispatch($job);

            unset($user);
            return Redirect::route('auth.login')->with('error', trans('auth.validation.validation_code_has_expired'));
        }

        $user->user_active = true;
        $user->confirmation_code = null;
        $user->save();

        event(new UserRegistrationConfirmation($user));

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