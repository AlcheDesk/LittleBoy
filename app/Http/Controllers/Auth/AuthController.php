<?php
namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Notifications\SignupActivate;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravolt\Avatar\Facade as Avatar;
use Exception;

class AuthController extends Controller
{
	use AuthenticatesUsers;

    /**
     * Create user deactivate and send notification to activate account user
     *
     * @param
     *            [string] name
     * @param
     *            [string] email
     * @param
     *            [string] password
     * @param
     *            [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'name' => 'required|string|max:15',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string'
            ]);

            $email = $request->email;
            $user = new User([
                'name' => $request->name,
                'email' => $email,
                'password' => bcrypt($request->password),
                // generate random activation token
                'activation_token' => str_random(60),
                // generate random v4 UUID for the user
                'uuid' => (string) Str::uuid()
            ]);
            $user->save();

            $avatar = Avatar::create($user->name)->getImageObject()->encode('png');
            Storage::put('avatars/' . $user->id . '/avatar.png', (string) $avatar);

            $user->notify(new SignupActivate($user));
            DB::commit();

            return response()->json([
                'user' => $user,
                'token' => $user->activation_token,
                'message' => new SignupActivate($user)
            ], 201);

            // return the usre ow juest created
            // return User::where('email', $email)->first();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function signupActivate($token)
    {
        DB::beginTransaction();

        try {
            // find the user first by the activation token
            $user = User::where('activation_token', $token)->first();
            // user not found
            if (! $user) {
                return response()->json([
                    'message' => __('auth.token_invalid')
                ], 404);
            }

            // update the user
            $user->active = true;
            $user->activation_token = '';
            $user->save();
            $user->notify(new SignupActivate($user));
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Login user and create token
     *
     * @param
     *            [string] email
     * @param
     *            [string] password
     * @param
     *            [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validateLogin($request);
            // check if the user is activated
            $email = $request->email;
			if (strpos($email, '@') !== false) {
				$nameType = 'email';
			} else {
				$nameType = 'name';
			}
            // $user = User::where('email', $email)->first();
            $user = User::where($nameType, $email)->first();
            if (! $user) {
                DB::commit();
                return response()->json([
                    'message' => __('auth.user_not_exist')
                ], 404);
            }
            if (! $user->active) {
                DB::commit();
                return response()->json([
                    'message' => __('auth.user_not_activated'),
                    'user' => $user
                ], 403);
            }

            // $credentials = request([
            //     $nameType,
            //     'password'
            // ]);
            $credentials['email'] = $user->email;
            $credentials['password'] = $request->password;
            $credentials['active'] = 1;
            $credentials['deleted_at'] = null;
            $credentials['activation_token'] = '';

            if (! Auth::attempt($credentials)) {
                return response()->json([
                    'message' => __('auth.login_failed')
                ], 401);
            }

            $user = $request->user();

            $tokenResult = $user->createToken('meowlomo');
            $token = $tokenResult->token;
            // update the token for the user
            if ($request->remember_me) {
                $token->expires_at = Carbon::now()->addWeeks(1);
            }            
            $token->save();
            DB::commit();

            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
            ]);
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->user()
                ->token()
                ->revoke();
            DB::commit();
            return response()->json([
                'message' => __('auth.logout_success')
            ]);
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    // public function logout(Request $request)
    // {
    // $this->guard()->logout();

    // $request->session()->invalidate();

    // return $this->loggedOut($request) ?: redirect('/');
    // }
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
