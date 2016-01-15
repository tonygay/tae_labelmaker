<?php

namespace AmigosLabels\Http\Middleware;

use Auth, Closure, Redirect;

class Admin
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
		if (!Auth::user()->admin) {
            return Redirect::route('home');
		}

        return $next($request);
    }
}
