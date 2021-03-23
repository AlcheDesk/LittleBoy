<?php
namespace App\Http\Middleware\RBAC;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdminMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if(env('DISABLE_AUTH')) {
			return $next($request);
		}
		if (!Auth::check()) {
			return redirect('/login');
		}

		if (!Auth::user()->hasRole('administrator')) // If user does //not have this permission
		{
			abort(403, 'Need to be administrator to perform this action.');
		}
		return $next($request);
	}
}
