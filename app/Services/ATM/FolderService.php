<?php
namespace App\Services\ATM;

use App\Mappers\ATM\FolderMapper;
use App\Services\Service;
use App\Services\Utils\RedisUtils\ATM\FolderRedisUtilService;
use App\Services\Utils\RedisUtils\ATM\TestCaseRedisUtilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\Utils\RedisUtils\Common\GenerateRedisKeyService;

class FolderService implements Service {

	private $mapper;
	private $folderRedisUtilService;
	private $testCaseRedisUtilService;
    private $generateRedisKeyService;

	public function __construct() {
		$this->mapper = new FolderMapper();
		$this->folderRedisUtilService = new FolderRedisUtilService();
		$this->testCaseRedisUtilService = new TestCaseRedisUtilService();
        $this->generateRedisKeyService = new GenerateRedisKeyService();
	}

	// base method start

	public function deleteByCondition(Request $request) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->deleteByOptions($this->mapper->parse_query($request->getQueryString()));
		$this->folderRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function deleteById(Request $request, $id) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->deleteById($id);
		$this->folderRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function insert(Request $request) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->insert($request->getContent());
		$this->folderRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function selectByCondition(Request $request) : string {
		// get the Model objects from mapper layer
        $redisKey = $this->generateRedisKeyService->generateRedisListKey($request->getQueryString());
		if ($this->folderRedisUtilService->hasRecordList($redisKey)) {
			$jsonStringResponse = $this->folderRedisUtilService->getRecordListFromCache($redisKey);
		} else {
			$jsonStringResponse = $this->mapper->selectByOptions($this->mapper->parse_query($request->getQueryString()));
			$this->folderRedisUtilService->cacheRecordList($redisKey, $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function selectById(Request $request, $id) : string {
		// get the Model objects from mapper layer
        $redisKey = $this->generateRedisKeyService->generateRedisKey($id,$request->getQueryString());
		if ($this->folderRedisUtilService->hasRecord($redisKey)) {
			$jsonStringResponse = $this->folderRedisUtilService->getRecordFromCache($redisKey);
		} else {
			$jsonStringResponse = $this->mapper->selectById($this->mapper->parse_query($request->getQueryString()), $id);
			$this->folderRedisUtilService->cacheRecord($redisKey, $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function update(Request $request) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->update($request->getContent());
		$this->folderRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function replace(Request $request) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->replace($request->getContent());
		$this->folderRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	// folder application link end

	// folder testCase link start

	public function getTestCaseByFolderId(Request $request, $folderId) : string {
        $redisKey = $this->generateRedisKeyService->generateRedisListKeyWithOtherInfo($request->getQueryString(),'folderId='.$folderId);
		if ($this->testCaseRedisUtilService->hasRecordList($redisKey)) {
			$jsonStringResponse = $this->testCaseRedisUtilService->getRecordListFromCache($redisKey);
		} else {
			$jsonStringResponse = $this->mapper->getTestCaseByFolderId($this->mapper->parse_query($request->getQueryString()), $folderId);
			$this->testCaseRedisUtilService->cacheRecordList($redisKey, $jsonStringResponse);
		}
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function deleteTestCaseByFolderId(Request $request, $id) : string {
		$jsonStringResponse = $this->mapper->deleteTestCaseFromFolder($this->mapper->parse_query($request->getQueryString()), $id);
		$this->testCaseRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function insertTestCaseByFolderId(Request $request, $folderId) : string {
		$jsonStringResponse = $this->mapper->insertTestCaseAndLinkToFolder($request->getContent(), $folderId);
		$this->testCaseRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function replaceTestCaseByFolderId(Request $request) : string {
		$jsonStringResponse = $this->mapper->replaceOrInsertTestCaseByFolder($request->getContent());
		$this->testCaseRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

}