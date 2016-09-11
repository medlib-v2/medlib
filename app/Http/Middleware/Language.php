<?php

namespace Medlib\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Session;

class Language {

    /**
     * @var $languages
     */
    protected $languages, $language;
    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * @var \Illuminate\Routing\Redirector
     */
    protected $redirector;

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Language constructor.
     * @param \Illuminate\Foundation\Application $app
     * @param \Illuminate\Routing\Redirector $redirector
     * @param \Illuminate\Http\Request $request
     *
     */
    public function __construct(Application $app, Redirector $redirector, Request $request) {
        $this->app = $app;
        $this->redirector = $redirector;
        $this->request = $request;
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

        if(Session::has('lang')){ $this->language = Session::get('lang'); }
        elseif(!$request->header('accept-language') == "") {

            $this->languages = $request->header('accept-language');
            $this->language = substr($this->languages,0,2);

        }
        else { $this->language = 'en'; }

        $this->app->setLocale($this->language);
        return $next($request);
    }
}