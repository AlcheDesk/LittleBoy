<?php

namespace App\Services\Utils\RedisUtils\ATM;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class ResultReportInstructionResultRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'ResultReportInstructionResult';
        $this->LIST_PREFIX = 'ResultReportInstructionResultList_';
        $this->PREFIX = 'ResultReportInstructionResult_';
        $this->COUNT_PREFIX = 'ResultReportInstructionResultCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*ResultReportInstructionResult*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}