<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {
	use Notifiable, HasApiTokens, SoftDeletes, HasRoles;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable = [
		'name', 'email', 'password', 'active', 'activation_token', 'avatar', 'uuid',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token', 'activation_token', 'uuid', 'pivot',
	];
	protected $dates = [];
	protected $appends = ['avatar_url'];

	public function getAvatarUrlAttribute() {
		return Storage::url('avatars/' . $this->id . '/' . $this->avatar);
	}

	public function memberships() {
		return $this->belongsToMany('App\Membership', 'user_has_membership');
	}

	public function accounts() {
		//get the memebership first
		$memberships = $this->memberships;
		//then we get the account from the memberships
		$accounts = array();
		foreach ($memberships as $membership) {
			$accountsFromMembership = $membership->accounts;
			foreach ($accountsFromMembership as $account) {
				array_push($accounts, $account);
			}
		}
		return $accounts;
	}
	
	public function accountUUIDs(){
	    $accounts = $this->accounts();
	    $uuids = array();
	    foreach ($accounts as $account) {
	        array_push($uuids, $account->uuid);
	    }
	    return $uuids;
	}
}
