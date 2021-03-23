<?php

namespace App\Services\Utils\RedisUtils\EMS;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class OperatingSystemRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'OperatingSystem';
        $this->LIST_PREFIX = 'OperatingSystemList_';
        $this->PREFIX = 'OperatingSystem_';
        $this->COUNT_PREFIX = 'OperatingSystemCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*OperatingSystem*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}