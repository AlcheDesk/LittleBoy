<?php
/**
 * User: tryndamere.wang
 * Date: 2018/12/20
 * Time: 10:39
 */
namespace App\Services\ATM;

use App\Mappers\ATM\ProjectExecutionInfoMapper;
use App\Services\Utils\RedisUtils\ATM\ProjectExecutionInfoRedisUtilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\Utils\RedisUtils\Common\GenerateRedisKeyService;

class ProjectExecutionInfoService {

	private $mapper;
	private $projectExecutionInfoRedisUtilService;
    private $generateRedisKeyService;

	public function __construct() {
		$this->mapper = new ProjectExecutionInfoMapper();
		$this->projectExecutionInfoRedisUtilService = new ProjectExecutionInfoRedisUtilService();
        $this->generateRedisKeyService = new GenerateRedisKeyService();
	}

	//projectExecutionInfo
	public function getProjectExecutionInfo(Request $request): string {
        $redisKey = $this->generateRedisKeyService->generateRedisListKey($request->getQueryString());
		if ($this->projectExecutionInfoRedisUtilService->hasRecordList($redisKey)) {
			$jsonStringResponse = $this->projectExecutionInfoRedisUtilService->getRecordListFromCache($redisKey);
		} else {
			$jsonStringResponse = $this->mapper->getProjectExecutionInfo($this->mapper->parse_query($request->getQueryString()));
			$this->projectExecutionInfoRedisUtilService->cacheRecordList($redisKey, $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getProjectExecutionInfoById(Request $request, $projectId): string {
        $redisKey = $this->generateRedisKeyService->generateRedisListKeyWithOtherInfo($request->getQueryString(),'projectId='.$projectId);
		if ($this->projectExecutionInfoRedisUtilService->hasRecord($redisKey)) {
			$jsonStringResponse = $this->projectExecutionInfoRedisUtilService->getRecordFromCache($redisKey);
		} else {
			$jsonStringResponse = $this->mapper->getProjectExecutionInfoById($this->mapper->parse_query($request->getQueryString()), $projectId);
			$this->projectExecutionInfoRedisUtilService->cacheRecord($redisKey, $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}
	
	public function getTestCaseExecutionInfoByProjectId(Request $request, $projectId): string {
        $redisKey = $this->generateRedisKeyService->generateRedisListKeyWithOtherInfo($request->getQueryString(),'projectId='.$projectId);
	    if ($this->projectExecutionInfoRedisUtilService->hasRecord($redisKey)) {
	        $jsonStringResponse = $this->projectExecutionInfoRedisUtilService->getRecordFromCache($redisKey);
	    } else {
	        $jsonStringResponse = $this->mapper->getTestCaseExecutionInfoByProjectId($this->mapper->parse_query($request->getQueryString()), $projectId);
	        $this->projectExecutionInfoRedisUtilService->cacheRecord($redisKey, $jsonStringResponse);
	    }
	    Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
	    return $jsonStringResponse;
	}
}
