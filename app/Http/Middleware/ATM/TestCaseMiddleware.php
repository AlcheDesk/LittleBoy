<?php
namespace App\Http\Middleware\ATM;

use Closure;
use Illuminate\Support\Facades\Auth;

class TestCaseMiddleware {

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
		if ($request->is('*projects*') && $request->is('*testCases*') && !$request->is('*resultReports*') && !$request->is('*statusReports*')) {
			// get the method from the request
			// chekc the permission base on the method
			if ($request->isMethod('post') && !$user->hasAnyPermission('add_test_cases', 'run_test_case')) {

				if ($request->is('*execute*') && !$user->hasPermissionTo('run_test_case')) {
					abort(403, 'Need to has add permission to perform this action.');
				}

				if (!$request->is('*execute*') && !$user->hasAnyPermission('add_test_cases', 'copy_test_cases')) {
					abort(403, 'Need to has add permission to perform this action.');
				}

			} else if ($request->isMethod('delete') && !$user->hasPermissionTo('delete_test_cases')) {

				abort(403, 'Need to has delete permission to perform this action.');

			} else if ($request->isMethod('put') && !$user->hasAnyPermission('add_test_cases', 'edit_test_cases')) {

				abort(403, 'Need to has add and edit permission to perform this action.');

			} else if ($request->isMethod('patch') && !$user->hasPermissionTo('edit_test_cases')) {

				abort(403, 'Need to has edit permission to perform this action.');

			} else if ($request->isMethod('get') && !$user->hasPermissionTo('view_test_cases')) {

				abort(403, 'Need to has view permission to perform this action.');

			}
		}
		if ($request->is('*testCases*') && !$request->is('*projects*') && !$request->is('*resultReports*') && !$request->is('*statusReports*') && $request->is('*executionDriverMaps*') && $request->is('*driverPacks*') && $request->is('*instructions*') && $request->is('*storages*') && $request->is('*drivers*') && $request->is('*systemRequirements*') && $request->is('*execute*') && $request->is('*testCaseOverwrites*') && $request->is('*tags*')) {
			// get the method from the request
			// chekc the permission base on the method
			if ($request->isMethod('post') && !$user->hasAnyPermission('add_test_cases', 'run_test_case')) {

				if ($request->is('*execute*') && !$user->hasPermissionTo('run_test_case')) {
					abort(403, 'Need to has add permission to perform this action.');
				}

				if (!$request->is('*execute*') && !$user->hasPermissionTo('add_test_cases')) {
					abort(403, 'Need to has add permission to perform this action.');
				}

			} else if ($request->isMethod('delete') && !$user->hasPermissionTo('delete_test_cases')) {

				abort(403, 'Need to has delete permission to perform this action.');

			} else if ($request->isMethod('put') && !$user->hasAnyPermission('add_test_cases', 'edit_test_cases')) {

				abort(403, 'Need to has add and edit permission to perform this action.');

			} else if ($request->isMethod('patch') && !$user->hasPermissionTo('edit_test_cases')) {

				abort(403, 'Need to has edit permission to perform this action.');

			} else if ($request->isMethod('get') && !$user->hasPermissionTo('view_test_cases')) {

				abort(403, 'Need to has view permission to perform this action.');

			}
		}
		return $next($request);
	}
}
