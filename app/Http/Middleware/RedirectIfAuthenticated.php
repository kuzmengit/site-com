<?php

namespace site\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
 		\Log::info('It Logout -------------------------2');
		\Log::debug($request);
		if ($request->isMethod('get') && $request->is('auth/logout')) {
			Auth::logout();
		}
       if (Auth::guard($guard)->check()) {
		    // Auth::logout();
            return redirect('/');
        }
 		\Log::info('It Logout -------------------------40');
        return $next($request);
    }
}
