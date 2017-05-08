<?php

namespace Medlib\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Medlib\Events\JsonWebTokenExpired;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

/**
 * Suppress all rules containing "unused" in this
 * class RefreshJsonWebToken
 *
 * @SuppressWarnings("unused")
 */
class RefreshJsonWebToken extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $authenticatedUser = Auth::user();
        $hasValidToken = false;

        /**
         * Is the user has used "remember me" the token may not be in their session when they return
         */
        if ($request->session()->has('jwt-token')) {
            $token = str_replace("Bearer ", "", $request->session()->get('jwt-token'));

            try {
                $tokenUser = $this->auth->authenticate($token);

                if ($tokenUser->id !== $authenticatedUser->id) {
                    return $this->respond('Token does not belong to the authenticated user', 'user_not_found', 404);
                }
                $hasValidToken = true;
                $this->events->fire('tymon.jwt.valid', $tokenUser);
            } catch (TokenExpiredException $e) {
                $hasValidToken = false;
            } catch (JWTException $e) {
                if ($request->ajax()) {
                    return $this->respond('tymon.jwt.invalid', 'token_invalid', $e->getStatusCode(), [$e]);
                } else {
                    return redirect()->guest('auth/login');
                }
            }
        }

        /**
         * If there is no valid token, generate one
         */
        if (!$hasValidToken) {
            if ($authenticatedUser) {
                event(new JsonWebTokenExpired($authenticatedUser));
            }
            //return $this->respond('tymon.jwt.expired', 'token_expired', $e->getStatusCode(), [$e]);
        }

        return $next($request);
    }
}
