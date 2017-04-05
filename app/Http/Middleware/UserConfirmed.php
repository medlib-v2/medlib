<?php

namespace Medlib\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Mail;

class UserConfirmed
{

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $this->auth->getUser();
        $confirmed = $user->user_active;

        if (isset($confirmed) && $confirmed == "0") {
            /**
             * If the user has not had an activation token set
             */
            $confirmation_code = $user->confirmation_code;

            if (empty($confirmation_code)) {
                /**
                 * Generate a confirmation code
                 */
                $confirmation_code = hash_hmac('sha256', str_random(40), $user->email);
                $user->confirmation_code = $confirmation_code;
                $user->save();
                Mail::send('auth.email.verify', ['token' => $confirmation_code, 'username' => $user->username], function ($message) use ($user) {
                    $message->to($user->getEmailForPasswordReset(), $user->username)
                        ->subject('Activate your Notify account');
                });
            }
            return redirect()->guest('/activate');
        }
        return $next($request);
    }
}
