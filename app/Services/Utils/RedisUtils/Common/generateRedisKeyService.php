<?php

namespace App\Services\Utils\RedisUtils\Common;

use App\Http\Controllers\Auth\Accounts\LoginRecordController;
use Illuminate\Support\Facades\Auth;
// use App\User;
use App\Mappers\ATM\ATMBaseMapper;

class GenerateRedisKeyService
{

    protected $LIST_PREFIX;
    protected $ATMBaseMapper;

    public function __construct()
    {
        $this->LIST_PREFIX = 'List_';
        $this->ATMBaseMapper = new ATMBaseMapper();
    }

    public function generateRedisKey($id,$queryString) {
        $tenantId = $this->ATMBaseMapper->generateTenantId();
        return 'tenantId='.$tenantId.'_'.$id.'_'.$queryString;
    }

    public function generateRedisListKey($queryString) {
        $tenantId = $this->ATMBaseMapper->generateTenantId();
        return 'tenantId='.$tenantId.'_'.$queryString;
    }

    public function generateRedisListKeyWithOtherInfo($queryString,$otherInfo) {
        $tenantId = $this->ATMBaseMapper->generateTenantId();
        return 'tenantId='.$tenantId.'_'.$otherInfo.'_'.$queryString;
    }

}