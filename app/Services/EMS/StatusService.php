<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:44
 */
namespace App\Services\EMS;

use App\Mappers\EMS\StatusMapper;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\Utils\RedisUtils\EMS\StatusRedisUtilService;

class StatusService implements Service {
    
    private $mapper;
    private $groupRedisUtilService;
    
    public function __construct()
    {
        $this->mapper = new StatusMapper();
        $this->groupRedisUtilService = new StatusRedisUtilService();
    }
    
    public function deleteByCondition(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->deleteByOptions($this->mapper->parse_query($request->getQueryString()));
        $this->groupRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }
    
    public function deleteById(Request $request, $id) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->deleteById($id);
        $this->groupRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }
    
    public function insert(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->insert($request->getContent());
        $this->groupRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }
    
    public function selectByCondition(Request $request) : string
    {
        // get the Model objects from mapper layer
        if($this->groupRedisUtilService->hasRecordList($request->getQueryString())){
            $jsonStringResponse = $this->groupRedisUtilService->getRecordListFromCache($request->getQueryString());
        }else{
            $jsonStringResponse =$this->mapper->selectByOptions($this->mapper->parse_query($request->getQueryString()));
            $this->groupRedisUtilService->cacheRecordList($request->getQueryString(),$jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }
    
    public function selectById(Request $request, $id) : string
    {
        // get the Model objects from mapper layer
        if($this->groupRedisUtilService->hasRecord($id)){
            $jsonStringResponse = $this->groupRedisUtilService->getRecordFromCache($id);
        }else{
            $jsonStringResponse = $this->mapper->selectById($this->mapper->parse_query($request->getQueryString()), $id);
            $this->groupRedisUtilService->cacheRecord($id, $jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }
    
    public function update(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->update($request->getContent());
        $this->groupRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }
    
    public function replace(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->replace($request->getContent());
        $this->groupRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }
}
