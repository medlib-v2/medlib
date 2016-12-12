<?php

namespace Medlib\Http\Controllers\Auth;

use Exception;
use Medlib\Models\User;
use Illuminate\Http\Request;
use Medlib\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Medlib\Commands\RegisterSocialUserCommand;
use Laravel\Socialite\Two\User as UserProvider;
use Medlib\Services\SocialAccountService;

class SocialAuthController extends Controller
{
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
        if (!array_key_exists($provider, config('services'))) {
            return redirect()->route('auth.login');
        }

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
        if (!array_key_exists($provider, config('services'))) {
            redirect()->route('auth.login');
        }

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

        auth()->login($authUser, true);

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

        if ($authUser) {
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
            'confirmation_code' => User::generateToken()
        ]);
    }

    /**
     * @param \Laravel\Socialite\Two\User $providerUser
     *
     * @return null|string
     */
    protected static function generateUsername(UserProvider $providerUser)
    {
        $username = null;

        $username = substr(strtolower($providerUser->user['first_name']), 0, 1);
        $username .= "_";
        $username .= strtolower($providerUser->user['last_name']);

        return  $username;
    }
}
