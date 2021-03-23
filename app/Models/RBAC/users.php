<?php

namespace App\Models\RBAC;

use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    public function accounts()
    {
        return $this->belongsToMany(accounts::class,'accounts_users','accounts_id','users_id');
    }
}
