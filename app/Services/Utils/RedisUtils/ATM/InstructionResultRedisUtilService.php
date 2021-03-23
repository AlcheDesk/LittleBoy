<?php

namespace App\Services\Utils\RedisUtils\ATM;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class InstructionResultRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'InstructionResult';
        $this->LIST_PREFIX = 'InstructionResultList_';
        $this->PREFIX = 'InstructionResult_';
        $this->COUNT_PREFIX = 'InstructionResultCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*InstructionResult*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
            $keys = Redis::keys("*ResultReportInstructionResult*");
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
            $keys = Redis::keys("*StatusReportTestCase*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}