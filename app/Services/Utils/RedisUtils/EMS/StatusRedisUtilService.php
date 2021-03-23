<?php

namespace App\Services\Utils\RedisUtils\EMS;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class StatusRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'Status';
        $this->LIST_PREFIX = 'StatusList_';
        $this->PREFIX = 'Status_';
        $this->COUNT_PREFIX = 'StatusCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*Status*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}