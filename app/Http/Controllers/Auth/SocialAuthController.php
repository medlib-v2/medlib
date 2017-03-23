<?php

namespace Medlib\Http\Controllers\Auth;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Medlib\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Medlib\Services\SocialAccountService;
use Illuminate\Http\Response as IlluminateResponse;

/**
* @Middleware("guest")
*/
class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the social provider ie facebook/twitter etc
     *
     * @Get("/auth/{provider}", as="auth.social")
     * @Middleware("guest")
     *
     * @param string $provider
     * @return \Illuminate\Http\JsonResponse
     */
    public function redirectToSocialProvider($provider)
    {
        /**
         * Check to see if the provider is supported, if not
         * redirect the user back to where they came from
         */
        if (!array_key_exists($provider, config('services'))) {
            return $this->responseWithError(
                ['redirect' => '/login']
            , IlluminateResponse::HTTP_NOT_ACCEPTABLE);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleSocialProviderCallback($provider, Request $request)
    {
        /**
         * Check to see if the provider is supported, if not
         * abort the signup
         */
        if (!array_key_exists($provider, config('services'))) {
            return $this->responseWithError(
                ['redirect' => '/login'],
                IlluminateResponse::HTTP_NOT_ACCEPTABLE);
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
     * @return \Illuminate\Http\JsonResponse
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
            return $this->responseWithError(
                ['redirect' => '/login', 'message' => 'Something went wrong or You have rejected the app!'],
                IlluminateResponse::HTTP_NOT_ACCEPTABLE
            );
        }

        $authUser = SocialAccountService::findOrCreateUser($providerUser, 'facebook_id');

        auth()->login($authUser, true);
        $token = \JWTAuth::fromUser($authUser);

        return $this->responseWithSuccess($token);
    }

    /**
     * Obtain the user information from Twitter.
     * Handle Twitter callback
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
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
            return $this->responseWithError(
                ['redirect' => '/login', 'message' => 'Something went wrong or You have rejected the app!'],
                IlluminateResponse::HTTP_NOT_ACCEPTABLE
            );
        }

        $authUser = SocialAccountService::findOrCreateUser($providerUser, 'twitter_id');

        Auth::login($authUser, true);
        $token = \JWTAuth::fromUser($authUser);

        return $this->responseWithSuccess($token);
    }

    /**
     * Handle any missing call back methods
     */
    private function handleMissingCallbackMethod()
    {
        //
    }
}
