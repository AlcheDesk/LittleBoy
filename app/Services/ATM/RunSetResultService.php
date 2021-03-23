<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:44
 */
namespace App\Services\ATM;

use App\Mappers\ATM\RunSetResultMapper;
use App\Services\Utils\RedisUtils\ATM\RunSetResultRedisUtilService;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\Utils\RedisUtils\ATM\RunRedisUtilService;
use App\Services\Utils\RedisUtils\ATM\RunExecutionInfoRedisUtilService;
use App\Services\Utils\RedisUtils\Common\GenerateRedisKeyService;

class RunSetResultService implements Service
{

    private $mapper;
    private $runSetResultRedisUtilService;
    private $runRedisUtilService;
    private $runExecutionInfoRedisUtilService;
    private $generateRedisKeyService;

    public function __construct()
    {
        $this->mapper = new RunSetResultMapper();
        $this->runSetResultRedisUtilService = new RunSetResultRedisUtilService();
        $this->runRedisUtilService = new RunRedisUtilService();
        $this->runExecutionInfoRedisUtilService = new RunExecutionInfoRedisUtilService();
        $this->generateRedisKeyService = new GenerateRedisKeyService();
    }

    // base method start

    public function deleteByCondition(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->deleteByOptions($this->mapper->parse_query($request->getQueryString()));
        $this->runSetResultRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function deleteById(Request $request, $id) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->deleteById($id);
        $this->runSetResultRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function insert(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->insert($request->getContent());
        $this->runSetResultRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function selectByCondition(Request $request) : string
    {
        // get the Model objects from mapper layer
        $redisKey = $this->generateRedisKeyService->generateRedisListKey($request->getQueryString());
        if($this->runSetResultRedisUtilService->hasRecordList($redisKey)){
            $jsonStringResponse = $this->runSetResultRedisUtilService->getRecordListFromCache($redisKey);
        }else{
            $jsonStringResponse = $this->mapper->selectByOptions($this->mapper->parse_query($request->getQueryString()));
            $this->runSetResultRedisUtilService->cacheRecordList($redisKey,$jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function selectById(Request $request, $id) : string
    {
        // get the Model objects from mapper layer
        $redisKey = $this->generateRedisKeyService->generateRedisKey($id,$request->getQueryString());
        if($this->runSetResultRedisUtilService->hasRecord($redisKey)){
            $jsonStringResponse = $this->runSetResultRedisUtilService->getRecordFromCache($id);
        }else{
            $jsonStringResponse = $this->mapper->selectById($this->mapper->parse_query($request->getQueryString()), $id);
            $this->runSetResultRedisUtilService->cacheRecord($redisKey, $jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function update(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->update($request->getContent());
        $this->runSetResultRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function replace(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->replace($request->getContent());
        $this->runSetResultRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    // base method end

    // runSetResult run link start

    public function getRunByRunSetResultId(Request $request, $runSetResultId) : string
    {
        $redisKey = $this->generateRedisKeyService->generateRedisListKeyWithOtherInfo($request->getQueryString(),'runSetResultId=' . $runSetResultId);
        if($this->runRedisUtilService->hasRecordList($redisKey)){
            $jsonStringResponse =  $this->runRedisUtilService->getRecordListFromCache($redisKey);
        }else{
            $jsonStringResponse = $this->mapper->getRunByRunSetResultId($this->mapper->parse_query($request->getQueryString()), $runSetResultId);
            $this->runRedisUtilService->cacheRecordList($redisKey,$jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function deleteRunByRunSetResultId(Request $request, $runSetResultId) : string
    {
        $jsonStringResponse = $this->mapper->deleteRunFromRunSetResult($this->mapper->parse_query($request->getQueryString()), $runSetResultId);
        $this->runRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function insertRunByRunSetResultId(Request $request, $runSetResultId) : string
    {
        $jsonStringResponse = $this->mapper->insertRunAndLinkToRunSetResult($request->getContent(), $runSetResultId);
        $this->runRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function replaceRunByRunSetResultId(Request $request, $runSetResultId) : string
    {
        $jsonStringResponse = $this->mapper->replaceOrInsertRunByRunSetResult($request->getContent(), $runSetResultId);
        $this->runRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    // runSetResult run link end
    
    public function getRunExecutionInfoByRunSetResultId(Request $request, $runSetResultId): string {
        $redisKey = $this->generateRedisKeyService->generateRedisListKeyWithOtherInfo($request->getQueryString(),'runSetResultId=' . $runSetResultId);
        if ($this->runExecutionInfoRedisUtilService->hasRecord($redisKey)) {
            $jsonStringResponse = $this->runExecutionInfoRedisUtilService->getRecordFromCache($redisKey);
        } else {
            $jsonStringResponse = $this->mapper->getRunExecutionInfoByRunSetResultId($this->mapper->parse_query($request->getQueryString()), $runSetResultId);
            $this->runExecutionInfoRedisUtilService->cacheRecord($redisKey, $jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }
}