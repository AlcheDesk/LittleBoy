<?php
namespace App\Http\Middleware\ATM;

use Closure;
use Illuminate\Support\Facades\Auth;

class ProjectMiddleware {

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
		if ($request->is('*projects*') && !$request->is('*testCases*') && !$request->is('*elements*') && !$request->is('*applications*') && !$request->is('*resultReports*') && !$request->is('*statusReports*')) {
			// get the method from the request
			// chekc the permission base on the method
			if ($request->isMethod('post') && !$user->hasAnyPermission('add_projects', 'copy_projects')) {

				abort(403, 'Need to has add permission to perform this action.');

			} else if ($request->isMethod('delete') && !$user->hasPermissionTo('delete_projects')) {

				abort(403, 'Need to has delete permission to perform this action.');

			} else if ($request->isMethod('put') && !$user->hasAnyPermission('add_projects', 'edit_projects')) {

				abort(403, 'Need to has add and edit permission to perform this action.');

			} else if ($request->isMethod('patch') && !$user->hasPermissionTo('edit_projects')) {

				abort(403, 'Need to has edit permission to perform this action.');

			} else if ($request->isMethod('get') && !$user->hasPermissionTo('view_projects')) {

				abort(403, 'Need to has view_projects permission to perform this action.');

			}
		}
		return $next($request);
	}
}
