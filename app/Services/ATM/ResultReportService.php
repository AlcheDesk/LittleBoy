<?php
/**
 * User: tryndamere.wang
 * Date: 2018/12/20
 * Time: 10:39
 */
namespace App\Services\ATM;

use App\Mappers\ATM\ResultReportMapper;
use App\Services\Utils\RedisUtils\ATM\ResultReportChartRedisUtilService;
use App\Services\Utils\RedisUtils\ATM\ResultReportInstructionResultRedisUtilService;
use App\Services\Utils\RedisUtils\ATM\ResultReportProjectRedisUtilService;
use App\Services\Utils\RedisUtils\ATM\ResultReportRunRedisUtilService;
use App\Services\Utils\RedisUtils\ATM\ResultReportRunSetResultRedisUtilService;
use App\Services\Utils\RedisUtils\ATM\ResultReportStepLogRedisUtilService;
use App\Services\Utils\RedisUtils\ATM\ResultReportTestCaseRedisUtilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\Utils\RedisUtils\Common\GenerateRedisKeyService;

class ResultReportService {

	private $mapper;
	private $resultReportProjectRedisUtilService;
	private $resultReportTestCaseRedisUtilService;
	private $resultReportRunSetResultRedisUtilService;
	private $resultReportRunRedisUtilService;
	private $resultReportInstructionResultRedisUtilService;
	private $resultReportStepLogRedisUtilService;
	private $resultReportChartRedisUtilService;
    private $generateRedisKeyService;

	public function __construct() {
		$this->mapper = new ResultReportMapper();
		$this->resultReportProjectRedisUtilService = new ResultReportProjectRedisUtilService();
		$this->resultReportTestCaseRedisUtilService = new ResultReportTestCaseRedisUtilService();
		$this->resultReportRunSetResultRedisUtilService = new ResultReportRunSetResultRedisUtilService();
		$this->resultReportRunRedisUtilService = new ResultReportRunRedisUtilService();
		$this->resultReportInstructionResultRedisUtilService = new ResultReportInstructionResultRedisUtilService();
		$this->resultReportStepLogRedisUtilService = new ResultReportStepLogRedisUtilService();
		$this->resultReportChartRedisUtilService = new ResultReportChartRedisUtilService();
        $this->generateRedisKeyService = new GenerateRedisKeyService();
	}

	public function getResultReportProject(Request $request): string {
        $redisKey = $this->generateRedisKeyService->generateRedisListKey($request->getQueryString());
		if ($this->resultReportProjectRedisUtilService->hasRecordList($redisKey)) {
			$jsonStringResponse = $this->resultReportProjectRedisUtilService->getRecordListFromCache($redisKey);
		} else {
			$jsonStringResponse = $this->mapper->getResultReportProject($this->mapper->parse_query($request->getQueryString()));
			$this->resultReportProjectRedisUtilService->cacheRecordList($redisKey, $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getResultReportProjectById(Request $request, $projectId): string {
        $redisKey = $this->generateRedisKeyService->generateRedisListKeyWithOtherInfo($request->getQueryString(),'projectId='.$projectId);
        $redisKey = $this->generateRedisKeyService->generateRedisKey($projectId);
		if ($this->resultReportProjectRedisUtilService->hasRecord($redisKey)) {
			$jsonStringResponse = $this->resultReportProjectRedisUtilService->getRecordFromCache($redisKey);
		} else {
			$jsonStringResponse = $this->mapper->getResultReportProjectById($this->mapper->parse_query($request->getQueryString()), $projectId);
			$this->resultReportProjectRedisUtilService->cacheRecord($redisKey, $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getResultReportChartByProjectId(Request $request, $projectId): string {
        $redisKey = $this->generateRedisKeyService->generateRedisListKeyWithOtherInfo($request->getQueryString(),'projectId='.$projectId);
		if ($this->resultReportChartRedisUtilService->hasRecord($redisKey)) {
			$jsonStringResponse = $this->resultReportChartRedisUtilService->getRecordFromCache($redisKey);
		} else {
			$jsonStringResponse = $this->mapper->getResultReportChartByProjectId($this->mapper->parse_query($request->getQueryString()), $projectId);
			$this->resultReportChartRedisUtilService->cacheRecord($redisKey, $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getResultReportTestCaseByProjectId(Request $request, $projectId): string {
        $redisKey = $this->generateRedisKeyService->generateRedisListKeyWithOtherInfo($request->getQueryString(),'projectId='.$projectId);
		if ($this->resultReportTestCaseRedisUtilService->hasRecordList($redisKey)) {
			$jsonStringResponse = $this->resultReportTestCaseRedisUtilService->getRecordListFromCache($redisKey);
		} else {
			$jsonStringResponse = $this->mapper->getResultReportTestCaseByProjectId($this->mapper->parse_query($request->getQueryString()), $projectId);
			$this->resultReportTestCaseRedisUtilService->cacheRecordList($redisKey, $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

// duplicate routes here, we use these routes in RunSetResultService.php instead

	// public function getRunListReports(Request $request) : string
	// {
	//     if($this->resultReportRunSetResultRedisUtilService->hasResultReportRunSetResultList($request->getQueryString())){
	//         $jsonStringResponse = $this->resultReportRunSetResultRedisUtilService->getResultReportRunSetResultListFromCache($request->getQueryString());
	//     }else{
	//         $jsonStringResponse = $this->mapper->getRunListReports($this->mapper->parse_query($request->getQueryString()));
	//         $this->resultReportRunSetResultRedisUtilService->cacheResultReportRunSetResultList($request->getQueryString(),$jsonStringResponse);
	//     }
	//     Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
	//     return $jsonStringResponse;
	// }

	// public function getRunListReportById(Request $request, $runListId) : string
	// {
	//     if($this->resultReportRunSetResultRedisUtilService->hasResultReportRunSetResult($runListId)){
	//         $jsonStringResponse = $this->resultReportRunSetResultRedisUtilService->getResultReportRunSetResultFromCache($runListId);
	//     }else{
	//         $jsonStringResponse = $this->mapper->getRunListReportById($this->mapper->parse_query($request->getQueryString()), $runListId);
	//         $this->resultReportRunSetResultRedisUtilService->cacheResultReportRunSetResult($runListId, $jsonStringResponse);
	//     }
	//     Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
	//     return $jsonStringResponse;
	// }

// duplicate routes end

	public function getResultReportRunByRunSetResultId(Request $request, $runSetResultId): string {
        $redisKey = $this->generateRedisKeyService->generateRedisListKeyWithOtherInfo($request->getQueryString(),'runSetResultId='.$runSetResultId);
		if ($this->resultReportRunRedisUtilService->hasRecord($redisKey)) {
			$jsonStringResponse = $this->resultReportRunRedisUtilService->getRecordFromCache($redisKey);
		} else {
			$jsonStringResponse = $this->mapper->getResultReportRunByRunSetResultId($redisKey), $runSetResultId);
			$this->resultReportRunRedisUtilService->cacheRecord('runSetResultId=' . $runSetResultId . '_' . $request->getQueryString(), $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getResultReportTestCase(Request $request): string {
        $redisKey = $this->generateRedisKeyService->generateRedisListKey($request->getQueryString());
		if ($this->resultReportTestCaseRedisUtilService->hasRecordList($redisKey)) {
			$jsonStringResponse = $this->resultReportTestCaseRedisUtilService->getRecordListFromCache($redisKey);
		} else {
			$jsonStringResponse = $this->mapper->getResultReportTestCase($this->mapper->parse_query($request->getQueryString()));
			$this->resultReportTestCaseRedisUtilService->cacheRecordList($redisKey, $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getResultReportTestCaseById(Request $request, $testCaseId): string {
        $redisKey = $this->generateRedisKeyService->generateRedisListKeyWithOtherInfo($request->getQueryString(),'testCaseId='.$testCaseId);
		if ($this->resultReportTestCaseRedisUtilService->hasRecord($redisKey)) {
			$jsonStringResponse = $this->resultReportTestCaseRedisUtilService->getRecordFromCache($redisKey);
		} else {
			$jsonStringResponse = $this->mapper->getResultReportTestCaseById($this->mapper->parse_query($request->getQueryString()), $testCaseId);
			$this->resultReportTestCaseRedisUtilService->cacheRecord($redisKey, $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getResultReportRunByTestCaseId(Request $request, $testCaseId): string {
		if ($this->resultReportRunRedisUtilService->hasRecordList('testCaseId=' . $testCaseId . '_' . $request->getQueryString())) {
			$jsonStringResponse = $this->resultReportRunRedisUtilService->getRecordListFromCache('testCaseId=' . $testCaseId . '_' . $request->getQueryString());
		} else {
			$jsonStringResponse = $this->mapper->getResultReportRunByTestCaseId($this->mapper->parse_query($request->getQueryString()), $testCaseId);
			$this->resultReportRunRedisUtilService->cacheRecordList('testCaseId=' . $testCaseId . '_' . $request->getQueryString(), $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getResultReportRunById(Request $request, $runId): string {
		if ($this->resultReportRunRedisUtilService->hasRecord($runId)) {
			$jsonStringResponse = $this->resultReportRunRedisUtilService->getRecordFromCache($runId);
		} else {
			$jsonStringResponse = $this->mapper->getResultReportRunById($this->mapper->parse_query($request->getQueryString()), $runId);
			$this->resultReportRunRedisUtilService->cacheRecord($runId, $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getResultReportInstructionResultByRunId(Request $request, $runId): string {
		if ($this->resultReportInstructionResultRedisUtilService->hasRecordResultList('runId=' . $runId . '_' . $request->getQueryString())) {
			$jsonStringResponse = $this->resultReportInstructionResultRedisUtilService->getRecordResultListFromCache('runId=' . $runId . '_' . $request->getQueryString());
		} else {
			$jsonStringResponse = $this->mapper->getResultReportInstructionResultByRunId($this->mapper->parse_query($request->getQueryString()), $runId);
			$this->resultReportInstructionResultRedisUtilService->cacheRecordResultList('runId=' . $runId . '_' . $request->getQueryString(), $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getResultReportStepLogByInstructionResultId(Request $request, $instructionResultId): string {
		if ($this->resultReportStepLogRedisUtilService->hasRecordList('instructionResultId=' . $instructionResultId . '_' . $request->getQueryString())) {
			$jsonStringResponse = $this->resultReportStepLogRedisUtilService->getRecordListFromCache('instructionResultId=' . $instructionResultId . '_' . $request->getQueryString());
		} else {
			$jsonStringResponse = $this->mapper->getResultReportStepLogByInstructionResultId($this->mapper->parse_query($request->getQueryString()), $instructionResultId);
			$this->resultReportStepLogRedisUtilService->cacheRecordList('instructionResultId=' . $instructionResultId . '_' . $request->getQueryString(), $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

}
