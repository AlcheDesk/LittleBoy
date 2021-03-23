<?php

namespace App\Services\Utils\RedisUtils\ATM;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class ElementRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'Element';
        $this->LIST_PREFIX = 'ElementList_';
        $this->PREFIX = 'Element_';
        $this->COUNT_PREFIX = 'ElementCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*Element*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}