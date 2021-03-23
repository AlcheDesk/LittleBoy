<?php

namespace App\Services\Utils\RedisUtils\ATM;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class RunSetRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'RunSet';
        $this->LIST_PREFIX = 'RunSetList_';
        $this->PREFIX = 'RunSet_';
        $this->COUNT_PREFIX = 'RunSetCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*RunSet*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
            $keys = Redis::keys("*ResultReportRunSet*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}