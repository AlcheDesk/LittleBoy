<?php

namespace App\Services\Utils\RedisUtils\ATM;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class RunExecutionInfoRedisUtilService extends BaseRedisUtilService {

	public function __construct() {
		parent::__construct();
		$this->RECORD_NAME = 'RunExecutionInfo';
		$this->LIST_PREFIX = 'RunExecutionInfoList_';
		$this->PREFIX = 'RunExecutionInfo_';
		$this->COUNT_PREFIX = 'RunExecutionInfoCount_';
	}

	public function removeAllRelatedCache() {
		if ($this->REDIS_ENABLE) {
			$keys = Redis::keys("*RunExecutionInfo*");
			foreach ($keys as $key) {
				Redis::del($key);
			}
		}
	}
}