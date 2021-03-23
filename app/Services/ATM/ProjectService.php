<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:44
 */
namespace App\Services\ATM;

use App\Mappers\ATM\ProjectMapper;
use App\Services\Service;
use App\Services\Utils\RedisUtils\ATM\ProjectRedisUtilService;
use App\Services\Utils\RedisUtils\Common\GenerateRedisKeyService;
use App\Services\Utils\RedisUtils\ATM\TestCaseRedisUtilService;
use App\Services\Utils\RedisUtils\ATM\ApplicationRedisUtilService;
use App\Services\Utils\RedisUtils\ATM\ElementRedisUtilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectService implements Service
{

    private $mapper;
    private $projectRedisUtilService;
    private $generateRedisKeyService;
    private $testCaseRedisUtilService;
    private $applicationRedisUtilService;
    private $elementRedisUtilService;

    public function __construct()
    {
        $this->mapper = new ProjectMapper();
        $this->projectRedisUtilService = new ProjectRedisUtilService();
        $this->generateRedisKeyService = new GenerateRedisKeyService();
        $this->testCaseRedisUtilService = new TestCaseRedisUtilService();
        $this->applicationRedisUtilService = new ApplicationRedisUtilService();
        $this->elementRedisUtilService = new ElementRedisUtilService();
    }

    // base method start

    public function deleteByCondition(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->deleteByOptions($this->mapper->parse_query($request->getQueryString()));
        $this->projectRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function deleteById(Request $request, $id) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->deleteById($id);
        $this->projectRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function insert(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->insert($request->getContent());
        $this->projectRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function selectByCondition(Request $request) : string
    {   
        // get the Model objects from mapper layer
        $redisKey = $this->generateRedisKeyService->generateRedisListKey($request->getQueryString());
        if($this->projectRedisUtilService->hasRecordList($redisKey)){
            $jsonStringResponse = $this->projectRedisUtilService->getRecordListFromCache($redisKey);
        }else{
            $jsonStringResponse =$this->mapper->selectByOptions($this->mapper->parse_query($request->getQueryString()));
            $this->projectRedisUtilService->cacheRecordList($redisKey, $jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function selectById(Request $request, $id) : string
    {
        // get the Model objects from mapper layer
        $redisKey = $this->generateRedisKeyService->generateRedisKey($id,$request->getQueryString());
        if($this->projectRedisUtilService->hasRecord($redisKey)){
            $jsonStringResponse = $this->projectRedisUtilService->getRecordFromCache($redisKey);
        }else{
            $jsonStringResponse = $this->mapper->selectById($this->mapper->parse_query($request->getQueryString()), $id);
            $this->projectRedisUtilService->cacheRecord($redisKey, $jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function update(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->update($request->getContent());
        $this->projectRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function replace(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->replace($request->getContent());
        $this->projectRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    // base method end

    // project application link start
    
    public function getApplicationByProjectId(Request $request, $projectId) : string
    {
        $redisKey = $this->generateRedisKeyService->generateRedisListKeyWithOtherInfo($request->getQueryString(),'projectId='.$projectId);
        if($this->applicationRedisUtilService->hasRecordList($redisKey)){
            $jsonStringResponse =  $this->applicationRedisUtilService->getRecordListFromCache($redisKey);
        }else{
            $jsonStringResponse =$this->mapper->getApplicationByProjectId($this->mapper->parse_query($request->getQueryString()), $projectId);
            $this->applicationRedisUtilService->cacheRecordList($redisKey,$jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function deleteApplicationByProjectId(Request $request, $projectId) : string
    {
        $jsonStringResponse = $this->mapper->deleteApplicationFromProject($this->mapper->parse_query($request->getQueryString()), $projectId);
        $this->applicationRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function insertApplicationByProjectId(Request $request, $projectId) : string
    {
        $jsonStringResponse = $this->mapper->insertApplicationAndLinkToProject($request->getContent(), $projectId);
        $this->applicationRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function replaceApplicationByProjectId(Request $request, $projectId) : string
    {
        $jsonStringResponse = $this->mapper->replaceOrInsertApplicationByProject($request->getContent(), $projectId);
        $this->applicationRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function updateApplicationByProjectId(Request $request, $projectId) : string
    {
        $jsonStringResponse = $this->mapper->updateApplicationFromProject($request->getContent(), $projectId);
        $this->applicationRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }
    
    // project application link end

    // project testCase link start

    public function getTestCaseByProjectId(Request $request, $projectId) : string
    {
        if($this->testCaseRedisUtilService->hasRecordList('projectId='.$projectId.'_'.$request->getQueryString())){
            $jsonStringResponse =  $this->testCaseRedisUtilService->getRecordListFromCache('projectId='.$projectId.'_'.$request->getQueryString());
        }else{
            $jsonStringResponse =$this->mapper->getTestCaseByProjectId($this->mapper->parse_query($request->getQueryString()), $projectId);
            $this->testCaseRedisUtilService->cacheRecordList('projectId='.$projectId.'_'.$request->getQueryString(),$jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function deleteTestCaseByProjectId(Request $request, $projectId) : string
    {
        $jsonStringResponse = $this->mapper->deleteTestCaseFromProject($this->mapper->parse_query($request->getQueryString()), $projectId);
        $this->testCaseRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function insertTestCaseByProjectId(Request $request, $projectId) : string
    {
        $jsonStringResponse = $this->mapper->insertTestCaseAndLinkToProject($request->getContent(), $projectId);
        $this->testCaseRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function replaceTestCaseByProjectId(Request $request, $projectId) : string
    {
        $jsonStringResponse = $this->mapper->replaceOrInsertTestCaseByProject($request->getContent(), $projectId);
        $this->testCaseRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    // project testCase link end

    // project element link start

    public function getElementByProjectId(Request $request, $projectId) : string
    {
        if($this->elementRedisUtilService->hasRecordList('projectId='.$projectId.'_'.$request->getQueryString())){
            $jsonStringResponse =  $this->elementRedisUtilService->getRecordListFromCache('projectId='.$projectId.'_'.$request->getQueryString());
        }else{
            $jsonStringResponse =$this->mapper->getElementByProjectId($this->mapper->parse_query($request->getQueryString()), $projectId);
            $this->elementRedisUtilService->cacheRecordList('projectId='.$projectId.'_'.$request->getQueryString(),$jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function deleteElementByProjectId(Request $request, $projectId) : string
    {
        $jsonStringResponse = $this->mapper->deleteElementFromProject($this->mapper->parse_query($request->getQueryString()), $projectId);
        $this->elementRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function insertElementByProjectId(Request $request, $projectId) : string
    {
        $jsonStringResponse = $this->mapper->insertElementAndLinkToProject($request->getContent(), $projectId);
        $this->elementRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function replaceElementByProjectId(Request $request, $projectId) : string
    {
        $jsonStringResponse = $this->mapper->replaceOrInsertElementByProject($request->getContent(), $projectId);
        $this->elementRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    // project element link end
}