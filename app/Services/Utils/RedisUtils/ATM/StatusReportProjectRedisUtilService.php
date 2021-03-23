<?php

namespace App\Services\Utils\RedisUtils\ATM;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class StatusReportProjectRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'StatusReportProject';
        $this->LIST_PREFIX = 'StatusReportProjectList_';
        $this->PREFIX = 'StatusReportProject_';
        $this->COUNT_PREFIX = 'StatusReportProjectCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*StatusReportProject*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}