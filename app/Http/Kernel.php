<?php

namespace Medlib\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Medlib\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \Illuminate\Session\Middleware\StartSession::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \Medlib\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            //\Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Medlib\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' =>       \Medlib\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'jwt.auth' =>   \Medlib\Http\Middleware\RefreshJsonWebToken::class,
        'bindings' =>   \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' =>        \Illuminate\Auth\Middleware\Authorize::class,
        'guest' =>      \Medlib\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' =>   \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'language' =>   \Medlib\Http\Middleware\Language::class,
        'role' =>       \Zizaco\Entrust\Middleware\EntrustRole::class,
        'permission' => \Zizaco\Entrust\Middleware\EntrustPermission::class,
        'ability' =>    \Zizaco\Entrust\Middleware\EntrustAbility::class,
        'editown'     => \Medlib\Http\Middleware\EditOwn::class,
        'editgroup'   => \Medlib\Http\Middleware\EditGroup::class,
        'editpage'    => \Medlib\Http\Middleware\EditPage::class,
    ];
}
