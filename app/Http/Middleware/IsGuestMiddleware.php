<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class IsGuestMiddleware
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
        if(env('DISABLE_AUTH')) {
            return $next($request);   
        }
        if (Auth::guest()) // If user does //not have this permission
        {   
            abort(403, 'You neeed to be login to perform action.');
        }
        return $next($request);
    }
}
