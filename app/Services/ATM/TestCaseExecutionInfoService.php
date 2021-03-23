<?php
/**
 * User: tryndamere.wang
 * Date: 2018/12/20
 * Time: 10:39
 */
namespace App\Services\ATM;

use App\Mappers\ATM\TestCaseExecutionInfoMapper;
use App\Services\Utils\RedisUtils\ATM\TestCaseExecutionInfoRedisUtilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestCaseExecutionInfoService {

	private $mapper;
	private $testCaseExecutionInfoRedisUtilService;

	public function __construct() {
		$this->mapper = new TestCaseExecutionInfoMapper();
		$this->testCaseExecutionInfoRedisUtilService = new TestCaseExecutionInfoRedisUtilService();
	}

	//testCaseExecutionInfo
	public function getTestCaseExecutionInfo(Request $request): string {
		if ($this->testCaseExecutionInfoRedisUtilService->hasRecordList($request->getQueryString())) {
			$jsonStringResponse = $this->testCaseExecutionInfoRedisUtilService->getRecordListFromCache($request->getQueryString());
		} else {
			$jsonStringResponse = $this->mapper->getTestCaseExecutionInfo($this->mapper->parse_query($request->getQueryString()));
			$this->testCaseExecutionInfoRedisUtilService->cacheRecordList($request->getQueryString(), $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getTestCaseExecutionInfoById(Request $request, $testCaseId): string {
		if ($this->testCaseExecutionInfoRedisUtilService->hasRecord($testCaseId)) {
			$jsonStringResponse = $this->testCaseExecutionInfoRedisUtilService->getRecordFromCache($testCaseId);
		} else {
			$jsonStringResponse = $this->mapper->getTestCaseExecutionInfoById($this->mapper->parse_query($request->getQueryString()), $testCaseId);
			$this->testCaseExecutionInfoRedisUtilService->cacheRecord($testCaseId, $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}
}
