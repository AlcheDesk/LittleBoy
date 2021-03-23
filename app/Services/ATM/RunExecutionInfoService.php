<?php
/**
 * User: tryndamere.wang
 * Date: 2018/12/20
 * Time: 10:39
 */
namespace App\Services\ATM;

use App\Mappers\ATM\RunExecutionInfoMapper;
use App\Services\Utils\RedisUtils\ATM\RunExecutionInfoRedisUtilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\Utils\RedisUtils\Common\GenerateRedisKeyService;

class RunExecutionInfoService {

	private $mapper;
	private $runExecutionInfoRedisUtilService;
    private $generateRedisKeyService;

	public function __construct() {
		$this->mapper = new RunExecutionInfoMapper();
		$this->runExecutionInfoRedisUtilService = new RunExecutionInfoRedisUtilService();
        $this->generateRedisKeyService = new GenerateRedisKeyService();
	}

	//runExecutionInfo
	public function getRunExecutionInfo(Request $request): string {
        $redisKey = $this->generateRedisKeyService->generateRedisListKey($request->getQueryString());
		if ($this->runExecutionInfoRedisUtilService->hasRecordList($redisKey)) {
			$jsonStringResponse = $this->runExecutionInfoRedisUtilService->getRecordListFromCache($redisKey);
		} else {
			$jsonStringResponse = $this->mapper->getRunExecutionInfo($this->mapper->parse_query($request->getQueryString()));
			$this->runExecutionInfoRedisUtilService->cacheRecordList($redisKey, $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getRunExecutionInfoById(Request $request, $runId): string {
        $redisKey = $this->generateRedisKeyService->generateRedisListKey($runId);
		if ($this->runExecutionInfoRedisUtilService->hasRecord($redisKey)) {
			$jsonStringResponse = $this->runExecutionInfoRedisUtilService->getRecordFromCache($redisKey);
		} else {
			$jsonStringResponse = $this->mapper->getRunExecutionInfoById($this->mapper->parse_query($request->getQueryString()), $runId);
			$this->runExecutionInfoRedisUtilService->cacheRecord($redisKey, $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}
}
