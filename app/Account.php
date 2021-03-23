<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $account_level
 * @property string $expirated_at
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property Bill[] $bills
 * @property Membership[] $memberships
 */
class Account extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['uuid', 'name', 'account_level', 'description', 'expirated_at'];

    protected $hidden = array('pivot');

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bills()
    {
        return $this->belongsToMany('App\Bill', 'account_has_bill');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function memberships()
    {
        return $this->belongsToMany('App\Membership', 'account_has_membership');
    }
}
