<?php

namespace Medlib\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Medlib\Events\JsonWebTokenExpired;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class RefreshJsonWebToken extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param   null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $autheticated_user = Auth::guard($guard)->user();
        $has_valid_token = false;

        /**
         * Is the user has used "remember me" the token may not be in their session when they return
         */
        if ($request->session()->has('jwt-token')) {
            $token = str_replace("Bearer ", "", $request->session()->get('jwt-token'));

            try {
                $token_user = $this->auth->authenticate($token);

                if ($token_user->id !== $autheticated_user->id) {
                    return $this->respond('Token does not belong to the authenticated user', 'user_not_found', 404);
                }
                $has_valid_token = true;
                $this->events->fire('tymon.jwt.valid', $token_user);
            } catch (TokenExpiredException $e) {
                $has_valid_token = false;
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
        if (!$has_valid_token) {
            event(new JsonWebTokenExpired($autheticated_user));
            /**
             * return $this->respond('tymon.jwt.expired', 'token_expired', $e->getStatusCode(), [$e]);
             */
        }

        return $next($request);
    }
}
