<?php

namespace App\Services\Utils\RedisUtils\ATM;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class StatusReportRunSetRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'StatusReportRunSet';
        $this->LIST_PREFIX = 'StatusReportRunSetList_';
        $this->PREFIX = 'StatusReportRunSet_';
        $this->COUNT_PREFIX = 'StatusReportRunSetCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*StatusReportRunSet*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}