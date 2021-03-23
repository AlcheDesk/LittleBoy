<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:44
 */
namespace App\Services\ATM;

use App\Mappers\ATM\RunMapper;
use App\Services\Service;
use App\Services\Utils\RedisUtils\ATM\InstructionResultRedisUtilService;
use App\Services\Utils\RedisUtils\ATM\RunRedisUtilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\Utils\RedisUtils\Common\GenerateRedisKeyService;

class RunService implements Service {

	private $mapper;
	private $runRedisUtilService;
	private $instructionResultRedisUtilService;
    private $generateRedisKeyService;

	public function __construct() {
		$this->mapper = new RunMapper();
		$this->runRedisUtilService = new RunRedisUtilService();
		$this->instructionResultRedisUtilService = new InstructionResultRedisUtilService();
        $this->generateRedisKeyService = new GenerateRedisKeyService();
	}

	// base method start

	public function deleteByCondition(Request $request): string{
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->deleteByOptions($this->mapper->parse_query($request->getQueryString()));
		$this->runRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function deleteById(Request $request, $id): string{
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->deleteById($id);
		$this->runRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function insert(Request $request): string{
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->insert($request->getContent());
		$this->runRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function selectByCondition(Request $request): string {
		// get the Model objects from mapper layer
        $redisKey = $this->generateRedisKeyService->generateRedisListKey($request->getQueryString());
		if ($this->runRedisUtilService->hasRecordList($redisKey)) {
			$jsonStringResponse = $this->runRedisUtilService->getRecordListFromCache($redisKey);
		} else {
			$jsonStringResponse = $this->mapper->selectByOptions($this->mapper->parse_query($request->getQueryString()));
			$this->runRedisUtilService->cacheRecordList($redisKey, $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function selectById(Request $request, $id): string {
		// get the Model objects from mapper layer
        $redisKey = $this->generateRedisKeyService->generateRedisListKey($id);
		if ($this->runRedisUtilService->hasRecord($redisKey)) {
			$jsonStringResponse = $this->runRedisUtilService->getRecordFromCache($redisKey);
		} else {
			$jsonStringResponse = $this->mapper->selectById($this->mapper->parse_query($request->getQueryString()), $id);
			$this->runRedisUtilService->cacheRecord($redisKey, $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function update(Request $request): string{
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->update($request->getContent());
		$this->runRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function replace(Request $request): string{
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->replace($request->getContent());
		$this->runRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	// base method end

	// run instructionResult link start

	public function getInstructionResultByRunId(Request $request, $runId): string {
        $redisKey = $this->generateRedisKeyService->generateRedisListKeyWithOtherInfo($request->getQueryString(),'runId=' . $runId);
		if ($this->instructionResultRedisUtilService->hasRecordList($redisKey)) {
			$jsonStringResponse = $this->instructionResultRedisUtilService->getRecordListFromCache($redisKey);
		} else {
			$jsonStringResponse = $this->mapper->getInstructionResultByRunId($this->mapper->parse_query($request->getQueryString()), $runId);
			$this->instructionResultRedisUtilService->cacheRecordList($redisKey, $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function insertInstructionResultByRunId(Request $request, $runId): string{
		$jsonStringResponse = $this->mapper->insertInstructionResultAndLinkToRun($request->getContent(), $runId);
		$this->instructionResultRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function updateInstructionResultByRunId(Request $request, $runId): string{
		$jsonStringResponse = $this->mapper->updateInstructionResultFromRun($request->getContent(), $runId);
		$this->instructionResultRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	// run instructionResult link end

	// run executionLog link start

	public function getExecutionLogByRunId(Request $request, $runId): string{
		$jsonStringResponse = $this->mapper->getExecutionLogByRunId($this->mapper->parse_query($request->getQueryString()), $runId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function insertExecutionLogByRunId(Request $request, $runId): string{
		$jsonStringResponse = $this->mapper->insertExecutionLogAndLinkToRun($request->getContent(), $runId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function updateExecutionLogByRunId(Request $request, $runId): string{
		$jsonStringResponse = $this->mapper->updateExecutionLogFromRun($request->getContent(), $runId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	// run executionLog link end

	public function getTaskByRunId(Request $request, $runId): string {
		if ($this->instructionResultRedisUtilService->hasRecordList('runId=' . $runId . '_' . $request->getQueryString())) {
			$jsonStringResponse = $this->instructionResultRedisUtilService->getRecordListFromCache('runId=' . $runId . '_' . $request->getQueryString());
		} else {
			$jsonStringResponse = $this->mapper->getTaskByRunId($this->mapper->parse_query($request->getQueryString()), $runId);
			$this->instructionResultRedisUtilService->cacheRecordList('runId=' . $runId . '_' . $request->getQueryString(), $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function selectExecutionInfoById(Request $request, $id): string {
		// get the Model objects from mapper layer
		if ($this->runRedisUtilService->hasRecord($id)) {
			$jsonStringResponse = $this->runRedisUtilService->getRecordFromCache($id);
		} else {
			$jsonStringResponse = $this->mapper->selectExecutionInfoById($this->mapper->parse_query($request->getQueryString()), $id);
			$this->runRedisUtilService->cacheRecord($id, $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}
}
