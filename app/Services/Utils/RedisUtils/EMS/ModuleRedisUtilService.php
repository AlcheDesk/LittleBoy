<?php

namespace App\Services\Utils\RedisUtils\EMS;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class ModuleRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'Module';
        $this->LIST_PREFIX = 'ModuleList_';
        $this->PREFIX = 'Module_';
        $this->COUNT_PREFIX = 'ModuleCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*Module*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}