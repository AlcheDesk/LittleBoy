<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:44
 */
namespace App\Services\ATM;

use App\Mappers\ATM\RunSetMapper;
use App\Services\Service;
use App\Services\Utils\RedisUtils\ATM\RunSetRedisUtilService;
use App\Services\Utils\RedisUtils\ATM\TestCaseRedisUtilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\Utils\RedisUtils\Common\GenerateRedisKeyService;

class RunSetService implements Service {

	private $mapper;
    private $runSetRedisUtilService;
    private $testCaseRedisUtilService;
    private $generateRedisKeyService;

	public function __construct() {
		$this->mapper = new RunSetMapper();
        $this->runSetRedisUtilService = new RunSetRedisUtilService();
        $this->testCaseRedisUtilService = new TestCaseRedisUtilService();
        $this->generateRedisKeyService = new GenerateRedisKeyService();
	}

    // base method start

	public function deleteByCondition(Request $request) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->deleteByOptions($this->mapper->parse_query($request->getQueryString()));
		$this->runSetRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function deleteById(Request $request, $id) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->deleteById($id);
		$this->runSetRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function insert(Request $request) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->insert($request->getContent());
		$this->runSetRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function selectByCondition(Request $request) : string {
		// get the Model objects from mapper layer
        $redisKey = $this->generateRedisKeyService->generateRedisListKey($request->getQueryString());
        if($this->runSetRedisUtilService->hasRecordList($redisKey)){
            $jsonStringResponse = $this->runSetRedisUtilService->getRecordListFromCache($redisKey);
        }else{
            $jsonStringResponse = $this->mapper->selectByOptions($this->mapper->parse_query($request->getQueryString()));
            $this->runSetRedisUtilService->cacheRecordList($redisKey,$jsonStringResponse);
        }
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function selectById(Request $request, $id) : string {
		// get the Model objects from mapper layer
        $redisKey = $this->generateRedisKeyService->generateRedisKey($id,$request->getQueryString());
        if($this->runSetRedisUtilService->hasRecord($redisKey)){
            $jsonStringResponse = $this->runSetRedisUtilService->getRecordFromCache($redisKey);
        }else{
            $jsonStringResponse = $this->mapper->selectById($this->mapper->parse_query($request->getQueryString()), $id);
            $this->runSetRedisUtilService->cacheRecord($redisKey, $jsonStringResponse);
        }
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function update(Request $request) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->update($request->getContent());
		$this->runSetRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function replace(Request $request) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->replace($request->getContent());
		$this->runSetRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

    // base method end

    // runSet testCase link start

	public function deleteTestCaseByRunSetId(Request $request, $runSetId) : string {
		$jsonStringResponse = $this->mapper->deleteTestCaseFromRunSet($this->mapper->parse_query($request->getQueryString()), $runSetId);
		$this->testCaseRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function insertTestCaseByRunSetId(Request $request, $runSetId) : string {
		$jsonStringResponse = $this->mapper->insertTestCaseAndLinkToRunSet($request->getContent(), $runSetId);
		$this->testCaseRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getTestCaseByRunSetId(Request $request, $runSetId) : string {
        if($this->testCaseRedisUtilService->hasRecordList('runSetId='.$runSetId.'_'.$request->getQueryString())){
            $jsonStringResponse =  $this->testCaseRedisUtilService->getRecordListFromCache('runSetId='.$runSetId.'_'.$request->getQueryString());
        }else{
            $jsonStringResponse =$this->mapper->getTestCaseByRunSetId($this->mapper->parse_query($request->getQueryString()), $runSetId);
            $this->testCaseRedisUtilService->cacheRecordList('runSetId='.$runSetId.'_'.$request->getQueryString(),$jsonStringResponse);
        }
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function replaceTestCaseByRunSetId(Request $request, $runSetId) : string {
		$jsonStringResponse = $this->mapper->replaceOrInsertTestCaseByRunSet($request->getContent(), $runSetId);
		$this->testCaseRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}


	public function deleteAliasByRunSetId(Request $request, $runSetId) : string {
		$jsonStringResponse = $this->mapper->deleteAliasFromRunSet($this->mapper->parse_query($request->getQueryString()), $runSetId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

    // runSet testCase link end

    // runSet alias link start

	public function insertAliasByRunSetId(Request $request, $runSetId) : string {
		$jsonStringResponse = $this->mapper->insertAliasAndLinkToRunSet($request->getContent(), $runSetId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function getAliasByRunSetId(Request $request, $runSetId) : string {
		$jsonStringResponse = $this->mapper->getAliasByRunSetId($this->mapper->parse_query($request->getQueryString()), $runSetId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function replaceAliasByRunSetId(Request $request, $runSetId) : string {
		$jsonStringResponse = $this->mapper->replaceOrInsertAliasByRunSet($request->getContent(), $runSetId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

    // runSet alias link end

    // runSet job link start

	public function getJobByRunSetId(Request $request, $runSetId) : string {
		$jsonStringResponse = $this->mapper->getJobByRunSetId($this->mapper->parse_query($request->getQueryString()), $runSetId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

    // runSet job link end

    // runSet executionDriverMap link start

	public function getExecutionDriverMapByRunSetId(Request $request, $runSetId) : string {
		$jsonStringResponse = $this->mapper->getExecutionDriverMapByRunSetId($this->mapper->parse_query($request->getQueryString()), $runSetId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

    // runSet executionDriverMap link end

	// runSetTestCaseLink start

	public function deleteTestCaseLinkByRunSetId(Request $request, $testCaseId) : string {
		$jsonStringResponse = $this->mapper->deleteTestCaseLinkByRunSetId($this->mapper->parse_query($request->getQueryString()), $testCaseId);
		$this->testCaseRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function replaceTestCaseLinkByRunSetId(Request $request) : string {
		$jsonStringResponse = $this->mapper->replaceTestCaseLinkByRunSetId($request->getContent());
		$this->testCaseRedisUtilService->removeAllRelatedCache();
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	// runSetTestCaseLink end

	// runSet notification link start

	public function getNotificationByRunSetId(Request $request, $runSetId) : string {
		$jsonStringResponse = $this->mapper->getNotificationByRunSetId($this->mapper->parse_query($request->getQueryString()), $runSetId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function replaceNotificationByRunSetId(Request $request, $runSetId) : string {
		$jsonStringResponse = $this->mapper->replaceNotificationByRunSetId($request->getContent(), $runSetId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function deleteNotificationByRunSetId(Request $request, $runSetId) : string {
		$jsonStringResponse = $this->mapper->deleteNotificationByRunSetId($this->mapper->parse_query($request->getQueryString()), $runSetId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	// runSet notification link end
}
