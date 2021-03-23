<?php

namespace App\Services\Utils\RedisUtils\ATM;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class RunSetResultRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'RunSetResult';
        $this->LIST_PREFIX = 'RunSetResultList_';
        $this->PREFIX = 'RunSetResult_';
        $this->COUNT_PREFIX = 'RunSetResultCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*RunSetResult*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
            $keys = Redis::keys("*ResultReportRunSetResult*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}