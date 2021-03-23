<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property integer $account_id
 * @property integer $user_id
 * @property integer $role_id
 * @property string $memebership_email
 * @property string $membership_phone_number
 * @property string $expirated_at
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property Account[] $accounts
 * @property User[] $users
 */
class Membership extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['uuid', 'name', 'account_id', 'user_id', 'role_id', 'memebership_email', 'membership_phone_number', 'expirated_at', 'description', 'created_at', 'updated_at'];

    protected $hidden = array('pivot');

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function accounts()
    {
        return $this->belongsToMany('App\Account', 'account_has_membership');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_has_membership');
    }
}
