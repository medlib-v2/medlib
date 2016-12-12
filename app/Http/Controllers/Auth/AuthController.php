<?php

namespace Medlib\Http\Controllers\Auth;

use Carbon\Carbon;
use Medlib\Models\User;
use Illuminate\Http\Request;
use Medlib\Services\ProcessImage;
use Illuminate\Support\Facades\App;
use Medlib\Models\ConfirmationToken;
use Illuminate\Support\Facades\View;
use Medlib\Events\UserWasRegistered;
use Medlib\Commands\LoginUserCommand;
use Medlib\Commands\LogoutUserCommand;
use Medlib\Http\Controllers\Controller;
use Medlib\Commands\RegisterUserCommand;
use Illuminate\Support\Facades\Redirect;
use Medlib\Http\Requests\RegisterUserRequest;
use Medlib\Http\Requests\CreateSessionRequest;
use Medlib\Events\UserRegistrationConfirmation;

/**
 * @Middleware("guest", except={"logout"})
 */
class AuthController extends Controller
{

    /**
     * Show the Login Page
     *
     * @Get("/login", as="auth.login")
     * @Middleware("guest")
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLogin()
    {
        return View::make('auth.login');
    }

    /**
     * @Post("/login")
     * @Middleware("guest")
     *
     * @param CreateSessionRequest $request
     * @return mixed
     */
    public function doLogin(CreateSessionRequest $request)
    {
        $response = $this->dispatch(new LoginUserCommand($request));

        if ($response) {
            return redirect()->route('home');
        }

        return redirect()->back()->with('error', trans('auth.login.failed'));
    }

    /**
     * Show the register page
     * @Get("/register", as="auth.register")
     * @Middleware("guest")
     *
     * @return mixed
     */
    public function showRegister()
    {
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
    public function doRegister(RegisterUserRequest $request)
    {
        $user_avatar = App::make(ProcessImage::class)->execute($request->file('profileimage'), 'avatars/', 200, 200);

        $date_of_birth = Carbon::createFromDate($request->get('year'), $request->get('month'), $request->get('day'))->toDateString();

        $request->merge([
            'date_of_birth' => $date_of_birth,
            'user_avatar' => $user_avatar,
        ]);

        $this->dispatch(new RegisterUserCommand($request));

        return redirect()->route('home')->with('info', trans('auth.account_created_success'))
            ->with('success', trans('auth.email_was_sent'));
    }

    /**
     * @Get("reg_birthday", as="auth.reg_birthday")
     * @Middleware("guest")
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reg_birthday()
    {
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
    public function doLogout()
    {
        $response = $this->dispatch(new LogoutUserCommand());
        if (!$response) {
            return redirect()->route('home');
        }

        /**
         * $request = new Request(['username' => Auth::user()->getUsername]);
         * $response = $this->dispatch(LogoutUserCommand::class, $request, ['username' => Auth::user()->getUsername]);
         * #if($response) response()->json(['response' => 'success']);
         * Auth::logout();
         * return redirect()->route('home');
         **/
    }

    /**
     * @Get("/verify", as="auth.verify")
     * @Middleware("guest")
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $token
     *
     * @return mixed
     */
    public function doVerify($token, Request $request)
    {
        if (!$token) {
            return redirect()->route('home')->with('error', trans('auth.validation.need_validation_code'));
        }

        $user = User::where('email', $request->get('email'))->firstOrFail();

        if (!$user or $user->userAccountIsActive()) {
            return redirect()->route('auth.login')->with('error', trans('auth.validation.validation_code_does_not_exist'));
        }

        $activation = ConfirmationToken::whereToken($token)->where('user_id', $user->id)
            ->first();

        if (empty($activation)) {
            return redirect()->route('auth.login')->with('error', trans('auth.validation.validation_code_does_not_exist'));
        }

        $timestamp_one_hour_ago = Carbon::now();
        $created = new Carbon($activation->updated_at);

        if ($created->diff($timestamp_one_hour_ago)->days >= 1 or $created->diffInHours($timestamp_one_hour_ago) >= 1) {
            $activation->token = ConfirmationToken::generateToken();
            $activation->save();

            $job = (new UserWasRegistered($user))->delay(60);

            $this->dispatch($job);

            unset($user);
            return redirect()->route('auth.login')->with('error', trans('auth.validation.validation_code_has_expired'));
        }

        $user->confirmEmail();

        $activation->delete();

        event(new UserRegistrationConfirmation($user));

        unset($user);

        return redirect()->route('auth.login')->with('success', trans('auth.validation.account_has_been_activated'));
    }
}
