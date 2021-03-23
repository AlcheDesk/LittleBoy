<?php

namespace App\Services\Utils\RedisUtils\ATM;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class SectionRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'Section';
        $this->LIST_PREFIX = 'SectionList_';
        $this->PREFIX = 'Section_';
        $this->COUNT_PREFIX = 'SectionCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*Section*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}