<?php

namespace App\Services\Utils\RedisUtils\ATM;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class ResultReportRunRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'ResultReportRun';
        $this->LIST_PREFIX = 'ResultReportRunList_';
        $this->PREFIX = 'ResultReportRun_';
        $this->COUNT_PREFIX = 'ResultReportRunCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*ResultReportRun*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}