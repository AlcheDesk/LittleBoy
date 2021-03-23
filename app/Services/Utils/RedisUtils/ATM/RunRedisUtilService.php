<?php

namespace App\Services\Utils\RedisUtils\ATM;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class RunRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'Run';
        $this->LIST_PREFIX = 'RunList_';
        $this->PREFIX = 'Run_';
        $this->COUNT_PREFIX = 'RunCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*Run*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
            $keys = Redis::keys("*ResultReportRun*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
            $keys = Redis::keys("*ResultReportTestCase*");
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
            $keys = Redis::keys("*StatusReportTestCase*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
            $keys = Redis::keys("*StatusReportRunSet*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
            $keys = Redis::keys("*StatusReportProject*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}