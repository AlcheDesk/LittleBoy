<?php
namespace App\Http\Middleware\ATM;

use Closure;
use Illuminate\Support\Facades\Auth;

class ApplicationMiddleware {

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
		if ($request->is('*applications*') && $request->is('*projects*')) {
			if ($request->isMethod('post') && !$user->hasPermissionTo('add_applications')) {

				abort(403, 'Need to has add permission to perform this action.');

			} else if ($request->isMethod('delete') && !$user->hasPermissionTo('delete_applications')) {

				abort(403, 'Need to has delete permission to perform this action.');

			} else if ($request->isMethod('put') && !$user->hasAnyPermission('add_applications', 'edit_applications')) {

				abort(403, 'Need to has add and edit permission to perform this action.');

			} else if ($request->isMethod('patch') && !$user->hasPermissionTo('edit_applications')) {

				abort(403, 'Need to has edit permission to perform this action.');

			} else if ($request->isMethod('get') && !$user->hasPermissionTo('view_applications')) {

				abort(403, 'Need to has view permission to perform this action.');

			}
		}
		if ($request->is('*applications*') && !$request->is('*projects*') && !$request->is('*sections*')) {
			if ($request->isMethod('delete') && !$user->hasPermissionTo('delete_applications')) {

				abort(403, 'Need to has delete permission to perform this action.');

			} else if ($request->isMethod('put') && !$user->hasAnyPermission('add_applications', 'edit_applications')) {

				abort(403, 'Need to has add and edit permission to perform this action.');

			} else if ($request->isMethod('patch') && !$user->hasPermissionTo('edit_applications')) {

				abort(403, 'Need to has edit permission to perform this action.');

			} else if ($request->isMethod('get') && !$user->hasPermissionTo('view_applications')) {

				abort(403, 'Need to has view permission to perform this action.');

			}
		}
		return $next($request);
	}
}
