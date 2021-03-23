<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Accounts\AccountController;
use App\Models\RBAC\accounts;
use App\User;
use App\Cache\AdvancedRateLimiter;
use App\Events\LoginEvent;
use App\Http\Controllers\Controller;
use App\Services\GeoIPService;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Auth;
use DB;
use DateTime;

class LoginController extends Controller {
	/*
	 * |--------------------------------------------------------------------------
	 * | Login Controller
	 * |--------------------------------------------------------------------------
	 * |
	 * | This controller handles authenticating users for the application and
	 * | redirecting them to your home screen. The controller uses a trait
	 * | to conveniently provide its functionality to your applications.
	 * |
	 */

	use AuthenticatesUsers;

	/**
	 * maxAttempts
	 *
	 * @var
	 */
	protected $maxAttempts;

	// public function showLoginForm() {
	// return view('UI.Auth.login');
	// }

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	//protected $redirectTo = '/home';


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Guard $auth) {
		$this->middleware('guest')->except('logout');
		$this->maxAttempts = 2; //captcha after 3 attempts
	}

	protected function credentials(Request $request) {
		// return $request->only($this->username(), 'password');
		$field = filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL) ? $this->username() : 'name';

		return [
			$field => $request->get($this->username()),
			'password' => $request->password,
		];
	}

	/**
	 * Show the application's login form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function showLoginForm() {
		return view('auth.login');
	}

	/**
	 * Determine if the user has too many failed login attempts.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return bool
	 */
	protected function hasTooManyLoginAttempts(Request $request) {
		return $this->limiter()->tooManyAttempts(
			$this->throttleKey($request), $this->maxAttempts()
		);
	}

	/**
	 * Get the rate limiter instance.
	 *
	 * @return \App\Cache\AdvancedRateLimiter
	 */
	protected function limiter() {
		return app(AdvancedRateLimiter::class);
	}

	public function getIpAndLocation() {
		return app(GeoIPService::class);
	}

	/**
	 * 返回位置信息中的参数[country]
	 *  [country] [是否为china]
	 */
	public function getCountryByLocation() {
		$locationmes = $this->getIpAndLocation()->getApplicationGeoInfo();
		return $locationmes['country'];
	}

	public function login(Request $request) {
		$domain = $request->domain;
		if (($domain == 'LDAP389') || ($domain == 'LDAP636')) {
			$loginForLdapController = new LoginForLdapController();
			return $loginForLdapController->login($request);
		} else if ($domain == 'local') {

			$this->validateLogin($request);

			$email = $request->email;
			if (strpos($email, '@') !== false) {
				$nameType = 'email';
			} else {
				$nameType = 'name';
			}
			$user = User::where($nameType, $email)->first();

			// If user not in database,then return false
			if (!isset($user['type'])) {
				throw ValidationException::withMessages([
					$this->username() => [
						trans('auth.user_not_exist'),
					],
				]);
			}

			// If type is not local,then return false
			if ($user->type != 'local') {
				throw ValidationException::withMessages([
					$this->username() => [
						trans('auth.user_not_exist'),
					],
				]);
			}

			if (!$user) {
				throw ValidationException::withMessages([
					$this->username() => [
						trans('auth.user_not_exist'),
					],
				]);
			}

			if (!$user->active) {
				throw ValidationException::withMessages([
					$this->username() => [
						trans('auth.user_not_activated'),
					],
				]);
			}

			// If the class is using the ThrottlesLogins trait, we can automatically throttle
			// the login attempts for this application. We'll key this by the username and
			// the IP address of the client making these requests into this application.
			if ($this->hasTooManyLoginAttempts($request)) {
				// $this->fireLockoutEvent($request);
				// 如果位置信息中的[country]等于'china' 展示普通图片验证码。否则返回谷歌验证码
				//$country = $this->getCountryByLocation();
				if (empty(env('LOCATION_COUNTRY'))) {
					return redirect()->back()->with('showimgcaptcha', 'Three login failures, please enter the authentication imgcaptcha code');
				} else if (strcasecmp(env('LOCATION_COUNTRY'), 'China') == 0) {
					return redirect()->back()->with('showimgcaptcha', 'Three login failures, please enter the authentication imgcaptcha code');
				} else {
					return redirect()->back()->with('showgooglecaptcha', 'Three login failures, please enter the authentication googlecaptcha code');
				}
			}

			$captcha = $request->captcha;
			//判断是否有图片验证码
			if (!empty($captcha)) {
				$captchaRules = ['captcha' => 'required|recaptcha'];

				$validator = Validator::make($request->all(), $captchaRules);
				if (!$validator->fails()) {
					if ($this->attemptLogin($request)) {
						return $this->sendLoginResponse($request, $user);
					} else {
						return redirect()->back()->with('captchainputerror', 'Wrong code. Try again please.');
					}
				}
			}
			//判断是否有谷歌验证码
			if ($request->has('g-recaptcha-response')) {
				$grecaptchaRules = ['g-recaptcha-response' => 'required|captcha'];

				$validator = Validator::make($request->all(), $grecaptchaRules);
				if (!$validator->fails()) {
					if ($this->attemptLogin($request)) {
						return $this->sendLoginResponse($request, $user);
					} else {
						return redirect()->back()->with('grecaptchainputerror', 'Wrong code. Try again please.');
					}
				}

			} else {
				if ($this->attemptLogin($request)) {

					return $this->sendLoginResponse($request, $user);
				}
			}

			// If the login attempt was unsuccessful we will increment the number of attempts
			// to login and redirect the user back to the login form. Of course, when this
			// user surpasses their maximum number of attempts they will get locked out.
			$this->incrementLoginAttempts($request);

			return $this->sendFailedLoginResponse($request);
		}
	}

	protected function sendLoginResponse(Request $request, $user) {
		$request->session()->regenerate();

		$token = $request->session()->token();
		$ipinfo = $this->getIpAndLocation()->getApplicationGeoInfo();
		$ip = $ipinfo['ip'];
		$location = $ipinfo['country'] . $ipinfo['city'];
		$login_mode_id = 1;
		$token_duration = '';

		//登录成功，添加监听事件，将用户登录信息保存
		event(new LoginEvent($user->name, $user->uuid, $ip, $location, $login_mode_id, (new DateTime()), $token, $token_duration));

		$this->clearLoginAttempts($request);

		return $this->authenticated($request, $this->guard()->user())
		?: redirect()->intended($this->redirectPath());
	}

    protected function redirectTo() {
        if(strcmp(env('CLOUD_CONFIG'),'public')==0){
            $user = Auth::user();
            $account =new  AccountController;
            $account_count = $account->countAccounts($user->id);

            $login_record = DB::table('login_record')->where('uuid',$user->uuid)->get();
            $login_record_current_id = $login_record->max('id');
            //当前登录用户对应多个account
            if ($account_count > 1){
                return '/auth/accounts/accountChoose';
            }
            //当前user对应一个account，且为首次登录
            else if($login_record->count() <= 1){
                 return '/auth/accounts';
            } else {
                $account = accounts::where('user_uuid',$user->uuid)->first();
                DB::table('login_record')->where('id',$login_record_current_id)->update(['current_account_id' => $account->id]);
                $user->current_account_id = $account->id;
                $user->save();
                return '/login';
            }
        }
        return '/login';
    }

}
