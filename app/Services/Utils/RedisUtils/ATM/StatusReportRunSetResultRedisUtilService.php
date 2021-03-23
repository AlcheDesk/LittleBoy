<?php

namespace App\Services\Utils\RedisUtils\ATM;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class StatusReportRunSetResultRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'StatusReportRunSetResult';
        $this->LIST_PREFIX = 'StatusReportRunSetResultList_';
        $this->PREFIX = 'StatusReportRunSetResult_';
        $this->COUNT_PREFIX = 'StatusReportRunSetResultCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*StatusReportRunSetResult*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}