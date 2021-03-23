<?php
namespace App\Http\Middleware\ATM;

use Closure;
use Illuminate\Support\Facades\Auth;

class ResultReportMiddleware {

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
		if ($request->is('*resultReport*')) {
			// if (! Auth::user()->hasRole('administrator|su')) {} else {
			// get the method from the request
			$user = Auth::user();
			// chekc the permission base on the method
			if ($request->isMethod('post') && !$user->hasPermissionTo('add_result_reports')) {

				abort(403, 'Need to has add permission to perform this action.');

			} else if ($request->isMethod('delete') && !$user->hasPermissionTo('delete_result_reports')) {

				abort(403, 'Need to has delete permission to perform this action.');

			} else if ($request->isMethod('put') && !$user->hasAnyPermission('add_result_reports', 'edit_result_reports')) {

				abort(403, 'Need to has add and edit permission to perform this action.');

			} else if ($request->isMethod('patch') && !$user->hasPermissionTo('edit_result_reports')) {

				abort(403, 'Need to has edit permission to perform this action.');

			} else if ($request->isMethod('get') && !$user->hasPermissionTo('view_run_result')) {

				abort(403, 'Need to has view permission to perform this action.');

			}
			// }
		}
		return $next($request);
	}
}
