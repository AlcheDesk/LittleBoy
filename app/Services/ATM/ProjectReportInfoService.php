<?php
/**
 * User: tryndamere.wang
 * Date: 2018/12/20
 * Time: 10:39
 */
namespace App\Services\ATM;

use App\Mappers\ATM\ProjectReportInfoMapper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\Utils\RedisUtils\ATM\ProjectReportInfoRedisUtilService;
use App\Services\Utils\RedisUtils\Common\GenerateRedisKeyService;

class ProjectReportInfoService {

	private $mapper;
	private $projectReportInfoRedisUtilService;
    private $generateRedisKeyService;

	public function __construct() {
		$this->mapper = new ProjectReportInfoMapper();
		$this->projectReportInfoRedisUtilService = new ProjectReportInfoRedisUtilService();
        $this->generateRedisKeyService = new GenerateRedisKeyService();
	}

	//projectReportInfo
	public function getProjectReportInfo(Request $request): string {
        $redisKey = $this->generateRedisKeyService->generateRedisListKey($request->getQueryString());
		if ($this->projectReportInfoRedisUtilService->hasRecordList($redisKey)) {
			$jsonStringResponse = $this->projectReportInfoRedisUtilService->getRecordListFromCache($redisKey);
		} else {
			$jsonStringResponse = $this->mapper->getProjectReportInfo($this->mapper->parse_query($request->getQueryString()));
			$this->projectReportInfoRedisUtilService->cacheRecordList($redisKey, $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getProjectReportInfoById(Request $request, $projectId): string {
        $redisKey = $this->generateRedisKeyService->generateRedisListKeyWithOtherInfo($request->getQueryString(),'projectId='.$projectId);
		if ($this->projectReportInfoRedisUtilService->hasRecord($redisKey)) {
			$jsonStringResponse = $this->projectReportInfoRedisUtilService->getRecordFromCache($redisKey);
		} else {
			$jsonStringResponse = $this->mapper->getProjectReportInfoById($this->mapper->parse_query($request->getQueryString()), $projectId);
			$this->projectReportInfoRedisUtilService->cacheRecord($redisKey, $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}
}
