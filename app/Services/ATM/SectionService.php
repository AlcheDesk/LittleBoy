<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:44
 */
namespace App\Services\ATM;

use App\Mappers\ATM\SectionMapper;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\Utils\RedisUtils\ATM\SectionRedisUtilService;
use App\Services\Utils\RedisUtils\ATM\ElementRedisUtilService;
use App\Services\Utils\RedisUtils\ATM\ApplicationRedisUtilService;
use App\Services\Utils\RedisUtils\Common\GenerateRedisKeyService;

class SectionService implements Service
{

    private $mapper;
    private $generateRedisKeyService;
    private $sectionRedisUtilService;
    private $elementRedisUtilService;
    private $applicationRedisUtilService;

    public function __construct()
    {
        $this->mapper = new SectionMapper();
        $this->generateRedisKeyService = new GenerateRedisKeyService();
        $this->sectionRedisUtilService = new SectionRedisUtilService();
        $this->elementRedisUtilService = new ElementRedisUtilService();
        $this->applicationRedisUtilService = new ApplicationRedisUtilService();
    }

    public function deleteByCondition(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->deleteByOptions($this->mapper->parse_query($request->getQueryString()));
        $this->sectionRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function deleteById(Request $request, $id) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->deleteById($id);
        $this->sectionRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function insert(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->insert($request->getContent());
        $this->sectionRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function selectByCondition(Request $request) : string
    {   
        // get the Model objects from mapper layer
        $redisKey = $this->generateRedisKeyService->generateRedisListKey($request->getQueryString());
        if($this->sectionRedisUtilService->hasRecordList($redisKey)){
            $jsonStringResponse = $this->sectionRedisUtilService->getRecordListFromCache($redisKey);
        }else{
            $jsonStringResponse =$this->mapper->selectByOptions($this->mapper->parse_query($request->getQueryString()));
            $this->sectionRedisUtilService->cacheRecordList($redisKey, $jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function selectById(Request $request, $id) : string
    {
        // get the Model objects from mapper layer
        $redisKey = $this->generateRedisKeyService->generateRedisKey($id,$request->getQueryString());
        if($this->sectionRedisUtilService->hasRecord($redisKey)){
            $jsonStringResponse = $this->sectionRedisUtilService->getRecordFromCache($redisKey);
        }else{
            $jsonStringResponse = $this->mapper->selectById($this->mapper->parse_query($request->getQueryString()), $id);
            $this->sectionRedisUtilService->cacheRecord($redisKey, $jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function update(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->update($request->getContent());
        $this->sectionRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function replace(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->replace($request->getContent());
        $this->sectionRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    // section element link start
    
    public function getElementBySectionId(Request $request, $sectionId) : string
    {
        $redisKey = $this->generateRedisKeyService->generateRedisListKeyWithOtherInfo($request->getQueryString(),'sectionId='.$sectionId);
        if($this->elementRedisUtilService->hasRecordList($redisKey)){
            $jsonStringResponse =  $this->elementRedisUtilService->getRecordListFromCache($redisKey);
        }else{
            $jsonStringResponse =$this->mapper->getElementBySectionId($this->mapper->parse_query($request->getQueryString()), $sectionId);
            $this->elementRedisUtilService->cacheRecordList($redisKey,$jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function deleteElementBySectionId(Request $request, $sectionId) : string
    {
        $jsonStringResponse = $this->mapper->deleteElementFromSection($this->mapper->parse_query($request->getQueryString()), $sectionId);
        $this->elementRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function insertElementBySectionId(Request $request, $sectionId) : string
    {
        $jsonStringResponse = $this->mapper->insertElementAndLinkToSection($request->getContent(), $sectionId);
        $this->elementRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function replaceElementBySectionId(Request $request, $sectionId) : string
    {
        $jsonStringResponse = $this->mapper->replaceOrInsertElementBySection($request->getContent(), $sectionId);
        $this->elementRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    // section element link end

    // other link start
    public function getApplicationBySectionId(Request $request, $sectionId) : string
    {
        $redisKey = $this->generateRedisKeyService->generateRedisListKeyWithOtherInfo($request->getQueryString(),'sectionId='.$sectionId);
        if($this->applicationRedisUtilService->hasRecordList($redisKey)){
            $jsonStringResponse =  $this->applicationRedisUtilService->getRecordListFromCache($redisKey);
        }else{
            $jsonStringResponse =$this->mapper->getApplicationBySectionId($this->mapper->parse_query($request->getQueryString()), $sectionId);
            $this->applicationRedisUtilService->cacheRecordList($redisKey,$jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }
    // other link end
}
