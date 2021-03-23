<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:44
 */
namespace App\Services\ATM;

use App\Mappers\ATM\ElementMapper;
use App\Services\Utils\RedisUtils\ATM\ElementRedisUtilService;
use App\Services\Utils\RedisUtils\Common\GenerateRedisKeyService;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ElementService implements Service
{

    private $mapper;
    private $elementRedisUtilService;
    private $generateRedisKeyService;

    public function __construct()
    {
        $this->mapper = new ElementMapper();
        $this->elementRedisUtilService = new ElementRedisUtilService();
        $this->generateRedisKeyService = new GenerateRedisKeyService();
    }

    public function deleteByCondition(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->deleteByOptions($this->mapper->parse_query($request->getQueryString()));
        $this->elementRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function deleteById(Request $request, $id) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->deleteById($id);
        $this->elementRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function insert(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->insert($request->getContent());
        $this->elementRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function selectByCondition(Request $request) : string
    {
        // get the Model objects from mapper layer
        $redisKey = $this->generateRedisKeyService->generateRedisListKey($request->getQueryString());
        if($this->elementRedisUtilService->hasRecordList($redisKey)){
            $jsonStringResponse = $this->elementRedisUtilService->getRecordListFromCache($redisKey);
        }else{
            $jsonStringResponse =$this->mapper->selectByOptions($this->mapper->parse_query($request->getQueryString()));
            $this->elementRedisUtilService->cacheRecordList($redisKey,$jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function selectById(Request $request, $id) : string
    {
        // get the Model objects from mapper layer
        $redisKey = $this->generateRedisKeyService->generateRedisKey($id,$request->getQueryString());
        if($this->elementRedisUtilService->hasRecord($redisKey)){
            $jsonStringResponse = $this->elementRedisUtilService->getRecordFromCache($redisKey);
        }else{
            $jsonStringResponse = $this->mapper->selectById($this->mapper->parse_query($request->getQueryString()), $id);
            $this->elementRedisUtilService->cacheRecord($redisKey, $jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function update(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->update($request->getContent());
        $this->elementRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function replace(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->replace($request->getContent());
        $this->elementRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    // element instructionAction link start

    public function getInstructionActionByElementId(Request $request, $elementId) : string
    {
        $jsonStringResponse = $this->mapper->getInstructionActionByElementId($this->mapper->parse_query($request->getQueryString()), $elementId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    // element instructionAction link end

    // element section link start

    public function getSectionByElementId(Request $request, $elementId) : string
    {
        $jsonStringResponse = $this->mapper->getSectionByElementId($this->mapper->parse_query($request->getQueryString()), $elementId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    // element section link end
}
