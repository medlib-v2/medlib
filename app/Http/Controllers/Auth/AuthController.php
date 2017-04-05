<?php

namespace Medlib\Http\Controllers\Auth;

use Carbon\Carbon;
use Medlib\Models\User;
use Medlib\Models\Timeline;
use Illuminate\Http\Request;
use Medlib\Services\ProcessImage;
use Illuminate\Support\Facades\App;
use Medlib\Models\ConfirmationToken;
use Illuminate\Support\Facades\View;
use Medlib\Events\UserWasRegistered;
use Medlib\Services\LoginUserService;
use Medlib\Services\LogoutUserService;
use Medlib\Http\Controllers\Controller;
use Medlib\Services\RegisterUserService;
use Medlib\Http\Requests\RegisterUserRequest;
use Medlib\Http\Requests\CreateSessionRequest;
use Medlib\Events\UserRegistrationConfirmation;
use Illuminate\Http\Response as IlluminateResponse;

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
        $response = $this->dispatch(new LoginUserService($request));

        if (array_key_exists ( 'error' , $response )) {

            switch ($response['error']) {
                case 'invalid_credentials':
                    $response['error'] = trans('auth.login.failed');
                    return $this->responseWithError($response, IlluminateResponse::HTTP_UNAUTHORIZED);
                    break;

                case 'login_failed':
                    $response['error'] = trans('auth.login.login_failed');
                    return $this->responseWithError($response, IlluminateResponse::HTTP_UNAUTHORIZED);
                    break;

                case 'activate_account':
                    $response['error'] = trans('auth.login.activate_account');
                    return $this->responseWithError($response, IlluminateResponse::HTTP_UNAUTHORIZED);
                    break;

                case 'could_not_create_token':
                    return $this->responseWithError($response, IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR);
                    break;
            }

        } else {
            return $this->responseWithSuccess([
                'token' => $response['token'],
                'user' =>  $response['user'],
            ]);
        }
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
        $user_avatar = App::make(ProcessImage::class)->execute($request->file('profileimage'), 'uploads/users/avatars/', 200, 200);

        $date_of_birth = Carbon::createFromDate($request->get('year'), $request->get('month'), $request->get('day'))->toDateString();

        if ($request->has('affiliate')) {
            $timeline = Timeline::where('username', $request->get('affiliate'))->first();
            $affiliate_id = $timeline->user->id;
        } else {
            $affiliate_id = null;
        }

        $request->merge([
            'date_of_birth' => $date_of_birth,
            'user_avatar' => $user_avatar,
            'affiliate_id' => $affiliate_id
        ]);


        $this->dispatch(new RegisterUserService($request));

        /**
        return redirect()->route('home')->with('info', trans('auth.account_created_success'))
        ->with('success', trans('auth.email_was_sent'));
         **/

        return $this->responseWithSuccess([
            'info' => trans('auth.account_created_success'),
            'success' => trans('auth.email_was_sent')
        ]);
    }

    /**
     * @Get("reg_birthday", as="auth.reg_birthday")
     * @Middleware("guest")
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function regBirthday()
    {
        return View::make('auth.reg_birthday');
    }

    /**
     * LogOut the user.
     *
     * @Get("/logout", as="auth.logout")
     * @Middleware("auth")
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function doLogout()
    {
        $response = $this->dispatch(new LogoutUserService);
        if (!$response) {
            return response()->json();
        }
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
