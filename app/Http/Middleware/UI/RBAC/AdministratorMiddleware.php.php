<?php

namespace App\Http\Middleware\UI\RBAC;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdministratorMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		$user = Auth::user();
		if ($request->is('*RBAC*')) {
			// get the method from the request
			// chekc the permission base on the method
			if ($request->isMethod('get') && !$user->hasPermissionTo('RBAC')) {

				abort(403, 'Need to has RBAC permission to perform this action.');

			}
			if ($request->is('*permission*')) {
				// get the method from the request
				// chekc the permission base on the method
				if ($request->isMethod('get') && !$user->hasPermissionTo('view_permissions')) {

					abort(403, 'Need to has view permission to perform this action.');

				}
			}
			if ($request->is('*group*')) {
				// get the method from the request
				// chekc the permission base on the method
				if ($request->isMethod('get') && !$user->hasPermissionTo('view_roles')) {

					abort(403, 'Need to has view permission to perform this action.');

				}
				if ($request->is('*users*')) {
					// get the method from the request
					// chekc the permission base on the method
					if ($request->isMethod('get') && !$user->hasPermissionTo('read_group_users')) {

						abort(403, 'Need to has view permission to perform this action.');

					}
				}
				if ($request->is('*permissions*')) {
					// get the method from the request
					// chekc the permission base on the method
					if ($request->isMethod('get') && !$user->hasPermissionTo('read_group_permissions')) {

						abort(403, 'Need to has view permission to perform this action.');

					}
				}
			}
			if ($request->is('*user*') && !$request->is('*group*')) {
				// get the method from the request
				// chekc the permission base on the method
				if ($request->isMethod('get') && !$user->hasPermissionTo('view_users')) {

					abort(403, 'Need to has view permission to perform this action.');

				}
			}
		}
		return $next($request);
	}
}
