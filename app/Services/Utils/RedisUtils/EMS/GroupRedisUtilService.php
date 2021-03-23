<?php

namespace App\Services\Utils\RedisUtils\EMS;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class GroupRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'Group';
        $this->LIST_PREFIX = 'GroupList_';
        $this->PREFIX = 'Group_';
        $this->COUNT_PREFIX = 'GroupCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*Group*");
            foreach ($keys as $key) {
                Redis::del($key);
            }
        }
    }
}