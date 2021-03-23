<?php
namespace App\Http\Controllers\UI\RBAC;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Administrator extends Controller {

	//
	private $locale;

	public function __construct() {
		$this->locale = new RBACLanguageController();
	}

	public function showAdministratorBasicInfo() {
		return view('UI.RBAC.administrator.basicInfo');
	}

	public function showAdminstratorAuthManagement() {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'permissions') !== false) {
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
		$lang = $this->locale->getAuthManagePageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];
		return view('UI.RBAC.administrator.authManagement', [
			'message' => json_encode($message),
		]);
	}

	public function showAdminstratorGroupManagement() {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'roles') !== false) {
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
		$lang = $this->locale->getGroupManagementPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];
		return view('UI.RBAC.administrator.groupManagement', [
			'message' => json_encode($message),
		]);
	}

	public function showGroupPermissionsManagement($id) {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'group_permissions') !== false) {
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
		$lang = $this->locale->getGroupPermissionManagementPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];
		return view('UI.RBAC.administrator.groupPermissionsManagement', [
			'message' => json_encode($message),
		]);
	}

	public function showGroupUsersManagement($id) {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'group_users') !== false) {
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
		$lang = $this->locale->getGroupUserManagementPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];
		return view('UI.RBAC.administrator.groupUsersManagement', [
			'message' => json_encode($message),
		]);
	}

	public function showAdminstratorUserManagement() {
		$permissions = Auth::user()->getAllPermissions()
			->filter(function ($value, $key) {
				if (strpos($value['name'], 'users') !== false) {
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
		$lang = $this->locale->getUserManagementPageLangMessage();
		$message = [
			'lang' => $lang,
			'permissions' => $permissions,
		];
		return view('UI.RBAC.administrator.userManagement', [
			'message' => json_encode($message),
		]);
	}

    public function showAdminstratorUserLogs() {
		$lang = $this->locale->getUserLogPageLangMessage();
		$message = [
			'lang' => $lang,
		];
		return view('UI.RBAC.administrator.userLog', [
			'message' => json_encode($message),
		]);
	}
}
