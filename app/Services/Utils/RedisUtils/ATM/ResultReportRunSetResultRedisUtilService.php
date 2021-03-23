<?php

namespace App\Services\Utils\RedisUtils\ATM;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class ResultReportRunSetResultRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'ResultReportRunSetResult';
        $this->LIST_PREFIX = 'ResultReportRunSetResultList_';
        $this->PREFIX = 'ResultReportRunSetResult_';
        $this->COUNT_PREFIX = 'ResultReportRunSetResultCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*ResultReportRunSetResult*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}