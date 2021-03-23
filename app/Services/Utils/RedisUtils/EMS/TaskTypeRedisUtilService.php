<?php

namespace App\Services\Utils\RedisUtils\EMS;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class TaskTypeRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'TaskType';
        $this->LIST_PREFIX = 'TaskTypeList_';
        $this->PREFIX = 'TaskType_';
        $this->COUNT_PREFIX = 'TaskTypeCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*TaskType*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}