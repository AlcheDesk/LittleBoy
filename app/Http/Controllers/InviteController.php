<?php

namespace App\Http\Controllers;

use App\Notifications\InviteCodeSend;
use Clarkeash\Doorman\Doorman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;


class InviteController extends Controller
{

	protected function validator(array $data) {
		return Validator::make($data, [
			'email' => 'required|string|email|max:255|unique:users',
		]);
	}

    function invitationCode(Request $request) {

    	$this->validator($request->all())
			->validate();

		//设置邀请码的过期时间，在xx天之后过期
	    $deadline= env("INVITE_CODE_DEADLINE","");
	    $userMail = $request['email'];

	    $inviteCodeStr = Doorman::generate()->for($userMail)->expiresIn($deadline)->make();
	    $inviteCode = $inviteCodeStr[0]['code'];

	    Notification::route('mail', $userMail)
	    			->notify(new InviteCodeSend($inviteCode));
	    
	    return redirect('register');
		}
}
