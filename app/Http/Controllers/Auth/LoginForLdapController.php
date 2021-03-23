<?php
namespace App\Http\Controllers\Auth;

use Adldap\Laravel\Facades\Adldap;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LoginForLdapController extends Controller {

	use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $email = $request->email;
        if (strpos($email, '@') !== false) {
            $nameType = 'mail';
        } else {
            $nameType = 'name';
        }

        $credentials = $request->only($this->username(), 'password');
        $username = $credentials[$this->username()];
        $password = $credentials['password'];
        if($nameType=='name'){
            $userkey = $username.'@szx';
        }else{
            $userkey = $username;
        }

        // if(Adldap::auth()->attempt($userkey, $password, $bindAsUser = true)) {

        $domain=$request->domain;
        if($domain=='LDAP389'){
            $con=ldap_connect('ldap://10.0.20.10','389');
        }else if($domain=='LDAP636'){
            $con=ldap_connect('ldaps://10.0.20.10','636');
        }
        $bind=ldap_bind($con,$userkey, $password);
        if($bind){
            // the user exists in the LDAP server, with the provided password

            $user = \App\User::where($nameType, $username)->first();
            if (!$user) {
                // the user doesn't exist in the local database, so we have to create one

                $user = new \App\User();
                $user->name = $username;
                $user->password = '';

                $user->uuid = (string) Str::uuid();
                $user->activation_token = '';

                $user->active = true;
                $user->type = 'LDAP';

                // you can skip this if there are no extra attributes to read from the LDAP server
                // or you can move it below this if(!$user) block if you want to keep the user always
                // in sync with the LDAP server 
                $sync_attrs = $this->retrieveSyncAttributes($username);
                foreach ($sync_attrs as $sync_attr_key => $sync_attr_value) {
                    // if ($sync_attr_key=='member_of'){
                    //     foreach($sync_attr_value as $member_of_k=>$member_of_value){
                    //         $t1 = mb_strpos($member_of_value,'CN=')+3;
                    //         $t2 = mb_strpos($member_of_value,',');
                    //         $group = mb_substr($member_of_value,$t1,$t2-$t1);
                    //         $group_array[$member_of_k]=$group;
                    //     }
                    //     continue;
                    // }
                    $user->$sync_attr_key = $sync_attr_value !== null ? $sync_attr_value : '';
                }
            }

            // by logging the user we create the session, so there is no need to login again (in the configured time).
            // pass false as second parameter if you want to force the session to expire when the user closes the browser.
            // have a look at the section 'session lifetime' in `config/session.php` for more options.

            $this->guard()->login($user, true);

            // assign the LDAP role to LDAP user
            // if(!empty($group_array)){
            //     $meowlomoUser = User::where('name', $username)->first();
            //     foreach($group_array as $group_k=>$group_value){
            //         if($group_value=='Jenkins Users'){
            //             $role = Role::findByName($group_value);
            //             $meowlomoUser->assignRole($group_value);
            //         }
            //     }
            // }

            ldap_unbind($con);
            return true;
        }

        // the user doesn't exist in the LDAP server or the password is wrong
        // log error
        return false;    
    }

    protected function retrieveSyncAttributes($username)
    {
        $ldapuser = Adldap::search()->where(env('LDAP_USER_ATTRIBUTE'), '=', $username)->first();
        if ( !$ldapuser ) {
            // log error
            return false;
        }
        // if you want to see the list of available attributes in your specific LDAP server:
        // var_dump($ldapuser->attributes); exit;

        // needed if any attribute is not directly accessible via a method call.
        // attributes in \Adldap\Models\User are protected, so we will need
        // to retrieve them using reflection.
        $ldapuser_attrs = null;

        $attrs = [];

        foreach (config('ldap_auth.sync_attributes') as $local_attr => $ldap_attr) {
            if ( $local_attr == 'username' ) {
                continue;
            }

            $method = 'get' . $ldap_attr;
            if (method_exists($ldapuser, $method)) {
                $attrs[$local_attr] = $ldapuser->$method();
                // $arr=$ldapuser->$method();
                // $attrs[$local_attr] = implode(";",$arr);
                continue;
            }

            if ($ldapuser_attrs === null) {
                $ldapuser_attrs = self::accessProtected($ldapuser, 'attributes');
            }

            if (!isset($ldapuser_attrs[$ldap_attr])) {
                // an exception could be thrown
                $attrs[$local_attr] = null;
                continue;
            }

            if (!is_array($ldapuser_attrs[$ldap_attr])) {
                $attrs[$local_attr] = $ldapuser_attrs[$ldap_attr];
            }

            if (count($ldapuser_attrs[$ldap_attr]) == 0) {
                // an exception could be thrown
                $attrs[$local_attr] = null;
                continue;
            }

            // now it returns the first item, but it could return
            // a comma-separated string or any other thing that suits you better
            $attrs[$local_attr] = $ldapuser_attrs[$ldap_attr][0];
        }

        return $attrs;
    }

    protected static function accessProtected ($obj, $prop)
    {
        $reflection = new \ReflectionClass($obj);
        $property = $reflection->getProperty($prop);
        $property->setAccessible(true);
        return $property->getValue($obj);
    }

}
