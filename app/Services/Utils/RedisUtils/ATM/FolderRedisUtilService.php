<?php

namespace App\Services\Utils\RedisUtils\ATM;

use App\Services\Utils\RedisUtils\BaseRedisUtilService;
use Illuminate\Support\Facades\Redis;

class FolderRedisUtilService extends BaseRedisUtilService {

	public function __construct() {
		parent::__construct();
		$this->RECORD_NAME = 'Folder';
		$this->LIST_PREFIX = 'FolderList_';
		$this->PREFIX = 'Folder_';
		$this->COUNT_PREFIX = 'FolderCount_';
	}

	public function removeAllRelatedCache() {
        if($this->REDIS_ENABLE){
		$keys = Redis::keys("*Folder*");
			foreach ($keys as $key) {
				Redis::del($key);
			}
		}
	}
}