<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $uuid
 * @property integer $account_id
 * @property string $billing_activities
 * @property float $total_amount
 * @property string $log
 * @property string $created_at
 * @property string $updated_at
 * @property Account[] $accounts
 * @property BillingActivity[] $billingActivities
 */
class Bill extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['uuid', 'account_id', 'billing_activities', 'total_amount', 'log', 'created_at', 'updated_at'];

    protected $hidden = array('pivot');

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function accounts()
    {
        return $this->belongsToMany('App\Account', 'account_has_bill');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function billingActivities()
    {
        return $this->belongsToMany('App\BillingActivity', 'bill_has_billing_activity');
    }
}
