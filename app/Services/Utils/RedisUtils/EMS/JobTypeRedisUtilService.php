<?php

namespace App\Services\Utils\RedisUtils\EMS;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class JobTypeRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'JobType';
        $this->LIST_PREFIX = 'JobTypeList_';
        $this->PREFIX = 'JobType_';
        $this->COUNT_PREFIX = 'JobTypeCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*JobType*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}