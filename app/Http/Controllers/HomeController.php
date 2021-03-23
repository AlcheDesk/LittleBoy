<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\RBAC\accounts;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$user = Auth::user();
		$accounts = accounts::where('id',$user->current_account_id)->first();
		if ($user->hasPermissionTo('RBAC')) {
			return view('home')->with('account_uuid', $accounts->uuid)->with('account_name', $accounts->name);
		} else {
			$permissions = $user->getAllPermissions()
				->filter(function ($value, $key) {
					if (strpos($value['name'], 'projects') !== false) {
						return true;
					}
					if (strpos($value['name'], 'system') !== false) {
						return true;
					}
				})
				->flatten()
				->pluck('name')
				->map(function ($name) {
					return [
						$name => true,
					];
				})
				->collapse()
				->all();
			return redirect()->route('Project');
		}

	}
}
