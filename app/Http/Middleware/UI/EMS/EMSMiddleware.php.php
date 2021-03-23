<?php

namespace App\Http\Middleware\UI\EMS;

use Closure;
use Illuminate\Support\Facades\Auth;

class EMSMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		$user = Auth::user();
		if ($request->is('*ems*')) {
			// get the method from the request
			// chekc the permission base on the method
			if ($request->isMethod('get') && !$user->hasPermissionTo('EMS')) {

				abort(403, 'Need to has EMS permission to perform this action.');

			}
		}
		return $next($request);
	}
}
