<?php

namespace App\Services\Utils\RedisUtils\ATM;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class ResultReportChartRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'ResultReportChart';
        $this->LIST_PREFIX = 'ResultReportChartList_';
        $this->PREFIX = 'ResultReportChart_';
        $this->COUNT_PREFIX = 'ResultReportChartCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*ResultReportChart*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}