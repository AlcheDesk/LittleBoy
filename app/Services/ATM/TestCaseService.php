<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:44
 */
namespace App\Services\ATM;

use App\Mappers\ATM\TestCaseMapper;
use App\Services\Service;
use App\Services\Utils\RedisUtils\ATM\InstructionRedisUtilService;
use App\Services\Utils\RedisUtils\ATM\TestCaseRedisUtilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestCaseService implements Service {

	private $mapper;
	private $testCaseRedisUtilService;
	private $instructionRedisUtilService;

	public function __construct() {
		$this->mapper = new TestCaseMapper();
		$this->testCaseRedisUtilService = new TestCaseRedisUtilService();
		$this->instructionRedisUtilService = new InstructionRedisUtilService();
	}

	// base method start

	public function deleteByCondition(Request $request): string{
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->deleteByOptions($this->mapper->parse_query($request->getQueryString()));
		$this->testCaseRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function deleteById(Request $request, $id): string{
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->deleteById($id);
		$this->testCaseRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function insert(Request $request): string{
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->insert($request->getContent());
		$this->testCaseRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function selectByCondition(Request $request): string {
		// get the Model objects from mapper layer
		if ($this->testCaseRedisUtilService->hasRecordList($request->getQueryString())) {
			$jsonStringResponse = $this->testCaseRedisUtilService->getRecordListFromCache($request->getQueryString());
		} else {
			$jsonStringResponse = $this->mapper->selectByOptions($this->mapper->parse_query($request->getQueryString()));
			$this->testCaseRedisUtilService->cacheRecordList($request->getQueryString(), $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function selectById(Request $request, $id): string {
		// get the Model objects from mapper layer
		if ($this->testCaseRedisUtilService->hasRecord($id)) {
			$jsonStringResponse = $this->testCaseRedisUtilService->getRecordFromCache($id);
		} else {
			$jsonStringResponse = $this->mapper->selectById($this->mapper->parse_query($request->getQueryString()), $id);
			$this->testCaseRedisUtilService->cacheRecord($id, $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function update(Request $request): string{
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->update($request->getContent());
		$this->testCaseRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function replace(Request $request): string{
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->replace($request->getContent());
		$this->testCaseRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	// base method end

	// testCase instruction link start

	public function getInstructionByTestCaseId(Request $request, $testCaseId): string {
		if ($this->instructionRedisUtilService->hasRecordList('testCaseId=' . $testCaseId . '_' . $request->getQueryString())) {
			$jsonStringResponse = $this->instructionRedisUtilService->getRecordListFromCache('testCaseId=' . $testCaseId . '_' . $request->getQueryString());
		} else {
			$jsonStringResponse = $this->mapper->getInstructionByTestCaseId($this->mapper->parse_query($request->getQueryString()), $testCaseId);
			$this->instructionRedisUtilService->cacheRecordList('testCaseId=' . $testCaseId . '_' . $request->getQueryString(), $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function deleteInstructionByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->deleteInstructionFromTestCase($this->mapper->parse_query($request->getQueryString()), $testCaseId);
		$this->instructionRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function insertInstructionByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->insertInstructionAndLinkToTestCase($request->getContent(), $testCaseId);
		$this->instructionRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function updateInstructionByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->updateInstructionFromTestCase($request->getContent(), $testCaseId);
		$this->instructionRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	// testCase instruction link end

	// testCase storage link start

	public function getStorageByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->getStorageByTestCaseId($this->mapper->parse_query($request->getQueryString()), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function deleteStorageByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->deleteStorageFromTestCase($this->mapper->parse_query($request->getQueryString()), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function insertStorageByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->insertStorageAndLinkToTestCase($request->getContent(), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function updateStorageByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->updateStorageFromTestCase($request->getContent(), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function replaceStorageByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->replaceOrInsertStorageByTestCase($request->getContent(), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	// testCase storage link end

	// testCase driver link start

	public function getDriverByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->getDriverByTestCaseId($this->mapper->parse_query($request->getQueryString()), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function deleteDriverByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->deleteDriverFromTestCase($this->mapper->parse_query($request->getQueryString()), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function insertDriverByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->insertDriverAndLinkToTestCase($request->getContent(), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function updateDriverByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->updateDriverFromTestCase($request->getContent(), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function replaceDriverByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->replaceOrInsertDriverByTestCase($request->getContent(), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	// testCase driver link end

	// testCase systemRequirement link start

	public function getSystemRequirementByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->getSystemRequirementByTestCaseId($this->mapper->parse_query($request->getQueryString()), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function deleteSystemRequirementByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->deleteSystemRequirementFromTestCase($this->mapper->parse_query($request->getQueryString()), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function insertSystemRequirementByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->insertSystemRequirementAndLinkToTestCase($request->getContent(), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function updateSystemRequirementByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->updateSystemRequirementFromTestCase($request->getContent(), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function replaceSystemRequirementByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->replaceOrInsertSystemRequirementByTestCase($request->getContent(), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	// testCase systemRequirement link end

	// testCase testCaseOption link start

	public function getTestCaseOptionByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->getTestCaseOptionByTestCaseId($this->mapper->parse_query($request->getQueryString()), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function deleteTestCaseOptionByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->deleteTestCaseOptionFromTestCase($this->mapper->parse_query($request->getQueryString()), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function insertTestCaseOptionByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->insertTestCaseOptionAndLinkToTestCase($request->getContent(), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function updateTestCaseOptionByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->updateTestCaseOptionFromTestCase($request->getContent(), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function replaceTestCaseOptionByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->replaceOrInsertTestCaseOptionByTestCase($request->getContent(), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	// testCase testCaseOption link end

	// testCase run link start

	public function getRunByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->getRunByTestCaseId($this->mapper->parse_query($request->getQueryString()), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function deleteRunByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->deleteRunFromTestCase($this->mapper->parse_query($request->getQueryString()), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function insertRunByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->insertRunAndLinkToTestCase($request->getContent(), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function updateRunByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->updateRunFromTestCase($request->getContent(), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function replaceRunByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->replaceOrInsertRunByTestCase($request->getContent(), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function replaceRunByTestCaseIdAndRunId(Request $request, $testCaseId, $runId): string{
		$jsonStringResponse = $this->mapper->replaceOrInsertRunByTestCase($request->getContent(), $testCaseId, $runId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function deleteRunByTestCaseIdAndRunId(Request $request, $testCaseId, $runId): string{
		$jsonStringResponse = $this->mapper->deleteRunFromTestCase($testCaseId, $runId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	// testCase run link end

	// testCase tag link start

	public function getTagByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->getTagByTestCaseId($this->mapper->parse_query($request->getQueryString()), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function deleteTagByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->deleteTagFromTestCase($this->mapper->parse_query($request->getQueryString()), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function insertTagByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->insertTagAndLinkToTestCase($request->getContent(), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function updateTagByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->updateTagFromTestCase($request->getContent(), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function replaceTagByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->replaceOrInsertTagByTestCase($request->getContent(), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	// testCase tag link end

	// others start

	public function getTestCaseFolderByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->getTestCaseFolderByTestCaseId($this->mapper->parse_query($request->getQueryString()), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getProjectByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->getProjectByTestCaseId($this->mapper->parse_query($request->getQueryString()), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getTaskByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->getTaskByTestCaseId($this->mapper->parse_query($request->getQueryString()), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getDriverPackByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->getDriverPackByTestCaseId($this->mapper->parse_query($request->getQueryString()), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getExecutionDriverMapByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->getExecutionDriverMapByTestCaseId($this->mapper->parse_query($request->getQueryString()), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getInstructionOverwriteByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->getInstructionOverwriteByTestCaseId($this->mapper->parse_query($request->getQueryString()), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getTestCaseOverwriteByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->getTestCaseOverwriteByTestCaseId($this->mapper->parse_query($request->getQueryString()), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function insertTestCaseOverwriteByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->insertTestCaseOverwriteByTestCaseId($request->getContent(), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	// others end

	//runExecutionInfo
	public function getRunExecutionInfoByTestCaseId(Request $request, $testCaseId): string{
		$jsonStringResponse = $this->mapper->getRunExecutionInfoByTestCaseId($this->mapper->parse_query($request->getQueryString()), $testCaseId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}
}
