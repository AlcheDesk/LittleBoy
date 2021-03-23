<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:44
 */
namespace App\Services\ATM;

use App\Mappers\ATM\ApplicationMapper;
use App\Services\Utils\RedisUtils\ATM\ApplicationRedisUtilService;
use App\Services\Utils\RedisUtils\ATM\SectionRedisUtilService;
use App\Services\Utils\RedisUtils\ATM\ProjectRedisUtilService;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\Utils\RedisUtils\Common\GenerateRedisKeyService;

class ApplicationService implements Service
{

    private $mapper;
    private $applicationRedisUtilService;
    private $sectionRedisUtilService;
    private $projectRedisUtilService;
    private $generateRedisKeyService;

    public function __construct()
    {
        $this->mapper = new ApplicationMapper();
        $this->applicationRedisUtilService = new ApplicationRedisUtilService();
        $this->sectionRedisUtilService = new SectionRedisUtilService();
        $this->generateRedisKeyService = new GenerateRedisKeyService();
        $this->projectRedisUtilService = new ProjectRedisUtilService();
    }

    public function deleteByCondition(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->deleteByOptions($this->mapper->parse_query($request->getQueryString()));
        $this->applicationRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function deleteById(Request $request, $id) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->deleteById($id);
        $this->applicationRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function insert(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->insert($request->getContent());
        $this->applicationRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function selectByCondition(Request $request) : string
    {
        // get the Model objects from mapper layer
        $redisKey = $this->generateRedisKeyService->generateRedisListKey($request->getQueryString());
        if($this->applicationRedisUtilService->hasRecordList($redisKey)){
            $jsonStringResponse = $this->applicationRedisUtilService->getRecordListFromCache($redisKey);
        }else{
            $jsonStringResponse =$this->mapper->selectByOptions($this->mapper->parse_query($request->getQueryString()));
            $this->applicationRedisUtilService->cacheRecordList($redisKey, $jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function selectById(Request $request, $id) : string
    {
        // get the Model objects from mapper layer
        $redisKey = $this->generateRedisKeyService->generateRedisKey($id,$request->getQueryString());
        if($this->applicationRedisUtilService->hasRecord($redisKey)){
            $jsonStringResponse = $this->applicationRedisUtilService->getRecordFromCache($redisKey);
        }else{
            $jsonStringResponse = $this->mapper->selectById($this->mapper->parse_query($request->getQueryString()), $id);
            $this->applicationRedisUtilService->cacheRecord($redisKey, $jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function update(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->update($request->getContent());
        $this->applicationRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function replace(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->replace($request->getContent());
        $this->applicationRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    // application section link start
    
    public function getSectionByApplicationId(Request $request, $applicationId) : string
    {
        $redisKey = $this->generateRedisKeyService->generateRedisListKeyWithOtherInfo($request->getQueryString(),'applicationId='.$applicationId);
        if($this->sectionRedisUtilService->hasRecordList($redisKey)){
            $jsonStringResponse =  $this->sectionRedisUtilService->getRecordListFromCache($redisKey);
        }else{
            $jsonStringResponse =$this->mapper->getSectionByApplicationId($this->mapper->parse_query($request->getQueryString()), $applicationId);
            $this->sectionRedisUtilService->cacheRecordList($redisKey,$jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function deleteSectionByApplicationId(Request $request, $applicationId) : string
    {
        $jsonStringResponse = $this->mapper->deleteSectionFromApplication($this->mapper->parse_query($request->getQueryString()), $applicationId);
        $this->sectionRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function insertSectionByApplicationId(Request $request, $applicationId) : string
    {
        $jsonStringResponse = $this->mapper->insertSectionAndLinkToApplication($request->getContent(), $applicationId);
        $this->sectionRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function replaceSectionByApplicationId(Request $request, $applicationId) : string
    {
        $jsonStringResponse = $this->mapper->replaceOrInsertSectionByApplication($request->getContent(), $applicationId);
        $this->sectionRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function updateSectionByApplicationId(Request $request, $applicationId) : string
    {
        $jsonStringResponse = $this->mapper->updateSectionFromApplication($request->getContent(), $applicationId);
        $this->sectionRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }
    
    // application section link end

    //  application project link start

    public function getProjectByApplicationId(Request $request, $applicationId) : string
    {
        $redisKey = $this->generateRedisKeyService->generateRedisListKeyWithOtherInfo($request->getQueryString(),'applicationId='.$applicationId);
        if($this->projectRedisUtilService->hasRecordList($redisKey)){
            $jsonStringResponse =  $this->projectRedisUtilService->getRecordListFromCache($redisKey);
        }else{
            $jsonStringResponse =$this->mapper->getProjectByApplicationId($this->mapper->parse_query($request->getQueryString()), $applicationId);
            $this->projectRedisUtilService->cacheRecordList($redisKey,$jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    //  application project link end
}
