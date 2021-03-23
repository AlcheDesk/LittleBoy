<?php

namespace App\Services\Utils\RedisUtils\ATM;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class ProjectExecutionInfoRedisUtilService extends BaseRedisUtilService {

	public function __construct() {
		parent::__construct();
		$this->RECORD_NAME = 'ProjectExecutionInfo';
		$this->LIST_PREFIX = 'ProjectExecutionInfoList_';
		$this->PREFIX = 'ProjectExecutionInfo_';
		$this->COUNT_PREFIX = 'ProjectExecutionInfoCount_';
	}

	public function removeAllRelatedCache() {
		if ($this->REDIS_ENABLE) {
			$keys = Redis::keys("*ProjectExecutionInfo*");
			foreach ($keys as $key) {
				Redis::del($key);
			}
		}
	}
}