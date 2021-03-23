<?php

namespace App\Services\Utils\RedisUtils\ATM;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class ResultReportProjectRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'ResultReportProject';
        $this->LIST_PREFIX = 'ResultReportProjectList_';
        $this->PREFIX = 'ResultReportProject_';
        $this->COUNT_PREFIX = 'ResultReportProjectCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*ResultReportProject*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}