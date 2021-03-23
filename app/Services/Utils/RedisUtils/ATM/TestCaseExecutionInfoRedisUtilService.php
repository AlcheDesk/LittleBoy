<?php

namespace App\Services\Utils\RedisUtils\ATM;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class TestCaseExecutionInfoRedisUtilService extends BaseRedisUtilService {

	public function __construct() {
		parent::__construct();
		$this->RECORD_NAME = 'TestCaseExecutionInfo';
		$this->LIST_PREFIX = 'TestCaseExecutionInfoList_';
		$this->PREFIX = 'TestCaseExecutionInfo_';
		$this->COUNT_PREFIX = 'TestCaseExecutionInfoCount_';
	}

	public function removeAllRelatedCache() {
		if ($this->REDIS_ENABLE) {
			$keys = Redis::keys("*TestCaseExecutionInfo*");
			foreach ($keys as $key) {
				Redis::del($key);
			}
		}
	}
}