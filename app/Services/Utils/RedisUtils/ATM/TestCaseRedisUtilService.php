<?php

namespace App\Services\Utils\RedisUtils\ATM;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class TestCaseRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'TestCase';
        $this->LIST_PREFIX = 'TestCaseList_';
        $this->PREFIX = 'TestCase_';
        $this->COUNT_PREFIX = 'TestCaseCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*TestCase*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
            $keys = Redis::keys("*ResultReportProject*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
            $keys = Redis::keys("*ResultReportChart*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
            $keys = Redis::keys("*ResultReportTestCase*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}