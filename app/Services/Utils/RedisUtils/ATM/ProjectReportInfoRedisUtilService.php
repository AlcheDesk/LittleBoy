<?php

namespace App\Services\Utils\RedisUtils\ATM;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class ProjectReportInfoRedisUtilService extends BaseRedisUtilService {

	public function __construct() {
		parent::__construct();
		$this->RECORD_NAME = 'ProjectReportfo';
		$this->LIST_PREFIX = 'ProjectReportfoList_';
		$this->PREFIX = 'ProjectReportfo_';
		$this->COUNT_PREFIX = 'ProjectReportfoCount_';
	}

	public function removeAllRelatedCache() {
		if ($this->REDIS_ENABLE) {
			$keys = Redis::keys("*ProjectReportfo*");
			foreach ($keys as $key) {
				Redis::del($key);
			}
		}
	}
}