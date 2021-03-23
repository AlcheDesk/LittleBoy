<?php

namespace App\Services\Utils\RedisUtils\ATM;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class StatusReportTestCaseRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'StatusReportTestCase';
        $this->LIST_PREFIX = 'StatusReportTestCaseList_';
        $this->PREFIX = 'StatusReportTestCase_';
        $this->COUNT_PREFIX = 'StatusReportTestCaseCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*StatusReportTestCase*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}