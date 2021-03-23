<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Accounts\AccountController;
use App\User;
use App\Http\Controllers\Controller;
use App\Models\RBAC\accounts;
use App\Notifications\RegisterActive;
use App\Notifications\RegisterActived;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Laravolt\Avatar\Facade as Avatar;


class RegisterController extends Controller {
	/*
	 * |--------------------------------------------------------------------------
	 * | Register Controller
	 * |--------------------------------------------------------------------------
	 * |
	 * | This controller handles the registration of new users as well as their
	 * | validation and creation. By default this controller uses a trait to
	 * | provide this functionality without requiring any additional code.
	 * |
	 */

	use RegistersUsers;

	/**
	 * Where to redirect users after registration.
	 *
	 * @var string
	 */
	// protected $redirectTo = '/login';
	protected function redirectTo() {
		return '/login';
	}

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('guest');
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param array $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data) {
		return Validator::make($data, [
			'name' => 'required|string|max:255|unique:users',
			'email' => 'required|string|email|max:255|unique:users',
			'password' => 'required|string|min:6|confirmed',
			// 'inviteCode' => 'required|string|min:4|doorman:email',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param array $data
	 * @return \App\User
	 */
	protected function create(array $data) {
		DB::beginTransaction();
		try {
			$user = User::create([
				'name' => $data['name'],
				'email' => $data['email'],
				// 'password' => Hash::make($data['password']),
				// 'inviteCode' => $data['inviteCode'],
				'password' => bcrypt($data['password']),
				'activation_token' => str_random(60),
				'uuid' => (string) Str::uuid(),
			]);

			// send out the email for activation and comfirmation
			Notification::send($user, new RegisterActive($user));

			// avator
			$avatar = Avatar::create($user->name)->getImageObject()->encode('png');
			Storage::put('avatars/' . $user->id . '/avatar.png', (string) $avatar);

            /*$user_uuid = $user->uuid;
            if(strcmp(env('CLOUD_CONFIG'),'public')==0){
            	$cloud_config = 'public';
            	DB::table('tenant')->insertGetId([
            		'user_uuid' => $user_uuid,
                    'cloud_config' => $cloud_config,
                    'tenant_id_private' => 0
            	]);
            } else{
            	$cloud_config = 'private';
            	DB::table('tenant')->insertGetId([
            		'user_uuid' => $user_uuid,
            		'cloud_config' => $cloud_config,
                    'tenant_id_private' => 1000
            	]);
            }*/


			// save to the database
			$user->save();

//            $this->createDefaultAccount($user);

            DB::commit();

			return $user;

		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}
	}

    /**
     * @param $user
     * 添加一个account，并更新与user的关联关系表
     */
	public function createDefaultAccount($user){
        $user_id = $user->id;
        $tenant_id = null;
        $accountController = new AccountController();

        if(strcmp(env('CLOUD_CONFIG'),'public')==0){
            $tenant_id_max = DB::table('accounts')->max('tenant_id');
            $tenant_id = $tenant_id_max + 1;

            $accountModel = new accounts;
            $accountModel->name = $user->name;
            $accountModel->uuid = $user->uuid;
            $accountModel->account_level = 'administrator';
            $accountModel->expirated_at = Carbon::now()->addDays(9999);
            $accountModel->description = 'administrator account';
            $accountModel->user_uuid = $user->uuid;
            $accountModel->tenant_id = $tenant_id;
//        $accountController->create($accountModel,$user_id);
            $account_id = $accountController->create($accountModel,$user_id);

            $role_info_admin = DB::table('roles')->where('name','administrator' )->first();
            $role_infoArr_admin = json_decode( json_encode( $role_info_admin),true);
            $role_id_admin = $role_infoArr_admin['id'];

            Log::info("=====reg===".$role_id_admin);

            $id = DB::table('account_role')->insertGetId([
                'user_id' => $user_id,
                'account_id' => $account_id,
                'role_id' => $role_id_admin //administrator
						]);
						
            $user->assignRole('administrator');

        } else{
            $user->assignRole('user');
        }
    }


	public function registerActive($token) {
		DB::beginTransaction();
		try {
			// find the user first by the activation token
			$user = User::where('activation_token', $token)->first();
			// user not found
			if (!$user) {
				return redirect('login')->with('type', 'danger')->with('message', __('auth.token_invalid'));
			}

			// give user default role
//			$user->assignRole('user');
      $this->createDefaultAccount($user);    //是不是？？？？？不需要默认account，如有需要，自己创建

			// update the user
			$user->active = true;
			$user->activation_token = '';

      if (strcmp(env('CLOUD_CONFIG'), 'public')==0) {
          $user->current_account_id = DB::table('accounts')->where('user_uuid', $user->uuid)->first()->id;
			}
			
			$user->save();
			Notification::send($user, new RegisterActived($user));
			DB::commit();

      if (strcmp(env('CLOUD_CONFIG'), 'public')==0) {
				DB::table('accounts_users')->where('accounts_id',$user->current_account_id)->where('users_id',$user->id)->update(['active' => true]);
			}
			
			return redirect('login')->with('type', 'success')->with('message', __('auth.email_register_actived'));
		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}
	}

	/**
	 * Handle a registration request for the application.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function register(Request $request) {
		$this->validator($request->all())
			->validate();

		// $email = $request['email'];
		// $inviteCode = $request['inviteCode'];

		// if (Doorman::check($inviteCode, $email)) {

		$this->create($request->all());

		return redirect('login')->with('type', 'success')->with('message', __('auth.email_signup_activate_line1'));

		// } else {
		//email和inviteCode不对应
		// return redirect('register');
		// }
	}
}
