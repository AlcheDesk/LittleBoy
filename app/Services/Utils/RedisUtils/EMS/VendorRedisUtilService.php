<?php

namespace App\Services\Utils\RedisUtils\EMS;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class VendorRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'Vendor';
        $this->LIST_PREFIX = 'VendorList_';
        $this->PREFIX = 'Vendor_';
        $this->COUNT_PREFIX = 'VendorCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*Vendor*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}