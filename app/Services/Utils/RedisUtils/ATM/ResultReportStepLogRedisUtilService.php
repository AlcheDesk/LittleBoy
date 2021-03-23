<?php

namespace App\Services\Utils\RedisUtils\ATM;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class ResultReportStepLogRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'ResultReportStepLog';
        $this->LIST_PREFIX = 'ResultReportStepLogList_';
        $this->PREFIX = 'ResultReportStepLog_';
        $this->COUNT_PREFIX = 'ResultReportStepLogCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*ResultReportStepLog*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}