<?php
namespace App\Http\Middleware\ATM;

use Closure;
use Illuminate\Support\Facades\Auth;

class DriverPackMiddleware {

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
		$user = Auth::user();
		if ($request->is('*driverPacks*') && !$request->is('*drivers*') && !$request->is('*testCases*')) {
			// get the method from the request
			// chekc the permission base on the method
			if ($request->isMethod('post') && !$user->hasPermissionTo('add_drivers_packs')) {

				abort(403, 'Need to has add permission to perform this action.');

			} else if ($request->isMethod('delete') && !$user->hasPermissionTo('delete_drivers_packs')) {

				abort(403, 'Need to has delete permission to perform this action.');

			} else if ($request->isMethod('put') && !$user->hasAnyPermission('add_drivers_packs', 'edit_drivers_packs')) {

				abort(403, 'Need to has add and edit permission to perform this action.');

			} else if ($request->isMethod('patch') && !$user->hasPermissionTo('edit_drivers_packs')) {

				abort(403, 'Need to has edit permission to perform this action.');

			} else if ($request->isMethod('get') && !$user->hasPermissionTo('view_drivers_packs')) {

				abort(403, 'Need to has view permission to perform this action.');

			}
		}
		if ($request->is('*driverPacks*') && $request->is('*testCases*')) {
			// get the method from the request
			// chekc the permission base on the method
			if ($request->isMethod('post') && !$user->hasPermissionTo('add_drivers_packs')) {

				abort(403, 'Need to has add permission to perform this action.');

			} else if ($request->isMethod('delete') && !$user->hasPermissionTo('delete_drivers_packs')) {

				abort(403, 'Need to has delete permission to perform this action.');

			} else if ($request->isMethod('put') && !$user->hasAnyPermission('add_drivers_packs', 'edit_drivers_packs')) {

				abort(403, 'Need to has add and edit permission to perform this action.');

			} else if ($request->isMethod('patch') && !$user->hasPermissionTo('edit_drivers_packs')) {

				abort(403, 'Need to has edit permission to perform this action.');

			} else if ($request->isMethod('get') && !$user->hasPermissionTo('view_drivers_packs')) {

				abort(403, 'Need to has view permission to perform this action.');

			}
		}
		return $next($request);
	}
}
