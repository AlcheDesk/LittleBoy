<?php

namespace App\Services\Utils\RedisUtils\ATM;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class InstructionRedisUtilService extends BaseRedisUtilService
{

    public function __construct()
    {
        parent::__construct();
        $this->RECORD_NAME = 'Instruction';
        $this->LIST_PREFIX = 'InstructionList_';
        $this->PREFIX = 'Instruction_';
        $this->COUNT_PREFIX = 'InstructionCount_';
    }

    public function removeAllRelatedCache()
    {
        if($this->REDIS_ENABLE){
            $keys = Redis::keys("*Instruction*");
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