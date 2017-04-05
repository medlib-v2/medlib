<?php

namespace Medlib\Http\Middleware;

use Closure;
use Medlib\Models\Timeline;

class EditPage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $timeline = Timeline::where('username', $request->username)->first();
        $page = $timeline->page()->first();

        if (!$page->is_admin(Auth::user()->id)) {
            return redirect($request->username);
        }

        return $next($request);
    }
}
