<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $uuid
 * @property integer $account_id
 * @property string $billing_activity_type
 * @property float $price
 * @property float $quantity
 * @property float $total_amount
 * @property string $log
 * @property string $created_at
 * @property string $updated_at
 * @property Bill[] $bills
 */
class BillingActivity extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['uuid', 'account_id', 'billing_activity_type', 'price', 'quantity', 'total_amount', 'log', 'created_at', 'updated_at'];

    protected $hidden = array('pivot');

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bills()
    {
        return $this->belongsToMany('App\Bill', 'bill_has_billing_activity');
    }
}
