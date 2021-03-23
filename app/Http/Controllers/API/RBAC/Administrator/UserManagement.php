<?php
namespace App\Http\Controllers\API\RBAC\Administrator;

use App\Http\Controllers\Auth\Accounts\AccountController;
use App\Http\Controllers\Auth\Accounts\LoginRecordController;
use App\Http\Controllers\Controller;
use App\Services\RBAC\UserManagementService;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravolt\Avatar\Facade as Avatar;
use function GuzzleHttp\json_encode;
use App\Models\RBAC\Role;
use App\Models\RBAC\accounts;
use App\Http\Controllers\Auth\Accounts\RoleController;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ReviewActived;
use App\Notifications\ReviewRefused;

class UserManagement extends Controller {

	private $baseService;

	public function __construct() {
		$this->baseService = new UserManagementService();
	}

	//
	public function selectByCondition(Request $request) {

		$authUser = $request->user();
		$id = $request->query('id');
		if ($id) {
			$groupUsers = $authUser->roles()
				->where('id', '=', $id)
				->first()
				->users()
				->get();
			$users = User::where('id', '!=', 1)->get();
			$diffUsers = $users->diff($groupUsers);
			$count = $diffUsers->count();
			$data = [
				'data' => $diffUsers,
				'error' => [],
				'metadata' => [
					'count' => $count,
					'groupUser' => $groupUsers,
					'users' => $users,
				],
			];
			return response($data, 200)->header('Content-Type', 'application/json; charset=utf8');
		} else {
			if ($authUser->name == 'meowlomo') {
				$users = User::where('active', 1)->get();
			} else {
        $account_id = $authUser->current_account_id;
        $accountController = new AccountController();
        $users = $accountController->usersByAccountId($account_id);
			}
			
			$defaultPageSize = $users->count();
			$pageSize = $request->query('pageSize', $defaultPageSize);
			$pageNumber = $request->query('pageNumber', 1);
			$searchName = $request->query('name', '');
			$orderBy = $request->query('orderBy', 'id desc');
			$user = $users->filter(function ($value, $key) use ($searchName) {
				if (!$searchName) {
					return true;
				}
				if (strpos($value['name'], $searchName, 0) !== false) {
					return true;
				}
			});

			$count = $user->count();

			if (strpos($orderBy, 'desc', 0) !== false) {
				$users = $user->sortByDesc(explode(' ', $orderBy)[0])
					->forPage($pageNumber, $pageSize)
					->flatten()
					->all();
			} else {
				$users = $user->sortBy(explode(' ', $orderBy)[0])
					->forPage($pageNumber, $pageSize)
					->flatten()
					->all();
			}


			foreach($users as $item) {
				if (!(DB::table('accounts_users')->where('accounts_id', $authUser->current_account_id)->where('users_id', $item->id)->first()->active)) {
					$item['account_active'] = false;
				} else {
					$item['account_active'] = true;
				}
			}


			$data = [
				'data' => $users,
				'error' => [],
				'metadata' => [
					'count' => $count,
				],
			];
			return response($data, 200)->header('Content-Type', 'application/json; charset=utf8');
		}
	}

	public function insert(Request $request) {
		DB::beginTransaction();
		try {
			$this->validate($request, [
				'name' => 'required|string|max:255',
				'email' => 'required|string|email|max:255|unique:users',
				'password' => 'required|string|min:6',
			]);
			$name = $request['name'];
			$email = $request['email'];
			$password = $request['password'];
			$user = new User();
			$user->uuid = Str::uuid();
			$user->name = $name;
			$user->email = $email;
			$user->password = bcrypt($password);
			$user->active = true;
			$user->account_active = true;
			$user->activation_token = '';
			$user->current_account_id = $request->user()->current_account_id;
			
			$avatar = Avatar::create($user->name)->getImageObject()->encode('png');
			Storage::put('avatars/' . $user->id . '/avatar.png', (string) $avatar);

			$user->save();
			DB::commit();

			$account = accounts::where('id', $request->user()->current_account_id)->first();
      if (strcmp($account->account_level, "team create account")==0) {
				DB::table('accounts_users')->insert(
					['accounts_id' => $user->current_account_id, 'users_id' => $user->id]
				);
				DB::table('account_role')->insertGetId([
					'user_id' => $user->id,
					'account_id' => $user->current_account_id,
					'role_id' => 3 //user
				]);
      }

			$user->assignRole('user');

			$data = [
				'data' => $user,
				'error' => [],
				'metadata' => [],
			];
			return response($data, 200)->header('Content-Type', 'application/json; charset=utf8');
		} catch (Exception $e) {
			DB::rollback();
		}
	}

	public function update(Request $request) {
		DB::beginTransaction();
		try {
			$this->validate($request, [
				'name' => 'required|string|max:255',
				'email' => 'required|string|email|max:255',
				'password' => 'required|string|min:6',
			]);
			$id = $request['id'];
			$user = User::findOrFail($id);
			$input = $request->only([
				'name',
				'email',
				'password',
			]);
			$user->fill($input)->save();
			DB::commit();
			$data = [
				'data' => $user,
				'error' => [],
				'metadata' => [],
			];
			return response($data, 200)->header('Content-Type', 'application/json; charset=utf8');
		} catch (Exception $e) {
			DB::rollback();
		}
	}

	public function destroy(Request $request, $id) {
		$user = $request->user();
		$account_user = DB::table('accounts_users')->where('users_id', $id)->first();
		$account_role = DB::table('account_role')->where('user_id', $id)->first();

		if ($account_user) {
			DB::table('accounts_users')->where('users_id', $id)->delete();
		}

		if ($account_role) {
			DB::table('account_role')->where('user_id', $id)->delete();
		}

		if ($user->id == 1 || $user->id == 2) {
			DB::beginTransaction();
			try {
				$user = User::where('id', '=', $id)->forceDelete();
				// $user->delete();
				DB::commit();
			} catch (Exception $e) {
				DB::rollback();
			}
		}
		$data = [
			'data' => $user,
			'error' => [],
			'metadata' => [],
		];
		return response($data, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function getRolesAndPermissionsMessage($id) {
		$user = User::findOrFail($id);

		/*$roles = $user->roles()
			->get()
			->unique('id')
			->all();*/
    $role = new LoginRecordController();
		$role_id = $role->get_role_id($user);
    $roleinfo = Role::findById($role_id);

    $roles = json_decode( json_encode( array($roleinfo)),true);

		$permissions = $user->getAllPermissions()
			->unique('name')
			->all();
		$data = [
			'data' => [
				'permissions' => $permissions,
				'roles' => $roles,
			],
			'error' => [],
			'metadata' => [],
		];
		return response($data, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function getNameOrEmailOfUserNumbers(Request $request) {
		$name = $request->query('name', '');
		$email = $request->query('email', '');
		if ($name !== '') {
			$userCount = User::withTrashed()->where('name', '=', $name)->count();
		} else {
			$userCount = User::withTrashed()->where('email', '=', $email)->count();
		}
		$data = [
			'data' => [],
			'error' => [],
			'metadata' => [
				'count' => $userCount,
			],
		];
		return response($data, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function readAdminstratorUserLogs(Request $request) {
		$jsonStringResponse = $this->baseService->selectByConditionRequest($request);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function getAccountsByUserUuid(string $uuid) {
		$user = User::where('uuid', $uuid)->first();
		if (!$user) {
			$data = [
				'data' => [],
				'error' => [],
				'metadata' => [],
			];
			return response($data, 200)->header('Content-Type', 'application/json; charset=utf8');
		} else {
			$accounts = $user->accounts();
			return response($accounts, 200)->header('Content-Type', 'application/json; charset=utf8');
		}
	}

	//用户通过account审核
	public function activateAccountUserByUserId(Request $request) {
		$active = $request->active;
		$user_id = $request->user_id;
		$account_id = $request->user()->current_account_id;
		$user = DB::table('users')->where('id', $user_id);
		if ($active) {
			DB::table('accounts_users')->where('accounts_id', $account_id)->where('users_id', $user_id)->update(['active' => true]);
      $role = new RoleController(); 
			$role->insert_role_relation($user_id, $account_id, 'user');
			Notification::send($user, new ReviewActived($user));
		} else {
			DB::table('accounts_users')->where('accounts_id', $account_id)->where('users_id', $user_id)->delete();
			$user['account_name'] = DB::table('accounts')->where('id', $account_id)->first()->name;
			Notification::send($user, new ReviewRefused($user));
		}
		$data = [
			'data' => [],
			'error' => [],
			'metadata' => [],
		];
		return response($data, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

}
