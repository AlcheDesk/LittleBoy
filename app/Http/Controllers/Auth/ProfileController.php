<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;
use App\User;


class ProfileController extends Controller
{
    public function profile(){
    	return view('/auth/profile', array('user' => Auth::user()) );
    }

    public function update_avatar(Request $request){

     	\Illuminate\Support\Facades\DB::beginTransaction();

     	$request->validate([
            'avatar' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

//         $url = url()->previous();
    	if($request->hasFile('avatar')){
    		
    		$user = Auth::user();

    		$avatar = $request->file('avatar');
    		$filename =$user->name.'_avatar'.time() . '.' . $avatar->getClientOriginalExtension();
    		
    		$request->avatar->move(public_path('upload/avatars/'), $filename);

    		$user = User::where('name', $user->name)->first();
    		$user->avatar = $filename;
    		$user->save();
    		DB::commit();
    	}
        return redirect()->back()->with('message','头像修改成功！');
    }

    public function update_profile_name(Request $request){

        $user = Auth::user();
        $user = User::where('name', $user->name)->first();

        if ($user->name != $request->input('name')) {
            $usernameRules = [
                'name' => 'required|string|max:255|unique:users',
            ];
        } else {
            return redirect()->back()->with('message','与当前用户名相同！建议您重新输入');
        }
        
        $validator = Validator::make($request->all(), $usernameRules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
            
            $name = $request->input('name');

            $user->name = $name;

            $user->save();
            DB::commit();
            return redirect()->back()->with('message','用户名修改成功！');
    }

    public function update_profile_email(Request $request){

        $user = Auth::user();
        $user = User::where('name', $user->name)->first();
        //$emailCheck = ($request->input('email') != '') && ($request->input('email') != $user->email);

        if ($user->email != $request->input('email')) {
            $emailRules = [
                'email' => 'required|string|email|max:255|unique:users',
            ];
        } else {
            return redirect()->back()->with('message','与当前邮箱地址相同！建议您重新输入');
            /*$emailRules = [
                'email' => 'email|max:255',
            ];*/
        }
        $validator = Validator::make($request->all(), $emailRules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
            
            $email = $request->input('email');

            $user->email = $email;

            $user->save();
            DB::commit();
            return redirect()->back()->with('message','邮箱地址修改成功！');
    }

    public function update_profile(Request $request){

        $user = Auth::user();
        $user = User::where('name', $user->name)->first();
        $emailCheck = ($request->input('email') != '') && ($request->input('email') != $user->email);
        $rules = [];

        if ($user->name != $request->input('name')) {
            $usernameRules = [
                'name' => 'required|string|max:255|unique:users',
            ];
        } else {
            $usernameRules = [
                'name' => 'required|max:255',
            ];
        }
        if ($emailCheck) {
            $emailRules = [
                'email' => 'required|string|email|max:255|unique:users',
            ];
        } else {
            $emailRules = [
                'email' => 'email|max:255',
            ];
        }
        $rules = array_merge($usernameRules, $emailRules);
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
            
            $name = $request->input('name');
            $email = $request->input('email');

            $user->name = $name;
            $user->email = $email;

            $user->save();
            DB::commit();
    }

    public function update_profile_password(Request $request){

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();
        $user = User::where('name', $user->name)->first();

        if ($request->input('old-password') != null) {
            if (Hash::check(Input::get('old-password') , $user->password )) {
                if ($request->input('password') != null) {
                    if (!Hash::check(Input::get('password') , $user->password )) {

                        DB::beginTransaction();

                        $user->password = bcrypt($request->input('password'));

                        $user->save();
                        DB::commit();
                        return redirect()->back()->with('message','密码修改成功！');
                    }
                    return redirect()->back()->with('message','与当前密码相同！建议您重新输入');
                }
                return redirect()->back()->with('message','新密码不能为空！请重新输入');
            } else {
                return redirect()->back()->with('message', '旧密码输入错误！请重新输入');
            }
        }
    }
}
