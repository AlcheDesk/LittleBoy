<?php

namespace App\Services\Utils\RedisUtils\ATM;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class ResultReportTestCaseRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'ResultReportTestCase';
        $this->LIST_PREFIX = 'ResultReportTestCaseList_';
        $this->PREFIX = 'ResultReportTestCase_';
        $this->COUNT_PREFIX = 'ResultReportTestCaseCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*ResultReportTestCase*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}