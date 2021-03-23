<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:44
 */
namespace App\Services\ATM;

use App\Mappers\ATM\InstructionResultMapper;
use App\Services\Service;
use App\Services\Utils\RedisUtils\ATM\InstructionResultRedisUtilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\Utils\RedisUtils\Common\GenerateRedisKeyService;

class InstructionResultService implements Service
{
    
    private $mapper;
    private $instructionResultRedisUtilService;
    private $generateRedisKeyService;

    public function __construct()
    {
        $this->mapper = new InstructionResultMapper();
        $this->instructionResultRedisUtilService = new InstructionResultRedisUtilService();
        $this->generateRedisKeyService = new GenerateRedisKeyService();
    }

    // base method start

    public function deleteByCondition(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->deleteByOptions($this->mapper->parse_query($request->getQueryString()));
        $this->instructionResultRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function deleteById(Request $request, $id) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->deleteById($id);
        $this->instructionResultRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function insert(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->insert($request->getContent());
        $this->instructionResultRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function selectByCondition(Request $request) : string
    {
        // get the Model objects from mapper layer
        $redisKey = $this->generateRedisKeyService->generateRedisListKey($request->getQueryString());
        if($this->instructionResultRedisUtilService->hasRecordList($redisKey)){
            $jsonStringResponse = $this->instructionResultRedisUtilService->getRecordListFromCache($redisKey);
        }else{
            $jsonStringResponse =$this->mapper->selectByOptions($this->mapper->parse_query($request->getQueryString()));
            $this->instructionResultRedisUtilService->cacheRecordList($redisKey,$jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function selectById(Request $request, $id) : string
    {
        // get the Model objects from mapper layer
        $redisKey = $this->generateRedisKeyService->generateRedisKey($id,$request->getQueryString());
        if($this->instructionResultRedisUtilService->hasRecord($redisKey)){
            $jsonStringResponse = $this->instructionResultRedisUtilService->getRecordFromCache($redisKey);
        }else{
            $jsonStringResponse = $this->mapper->selectById($this->mapper->parse_query($request->getQueryString()), $id);
            $this->instructionResultRedisUtilService->cacheRecord($redisKey, $jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function update(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->update($request->getContent());
        $this->instructionResultRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function replace(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->replace($request->getContent());
        $this->instructionResultRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    // base method end

    // instruction file link start
    
    public function insertFileByInstructionResultId(Request $request, $instructionResultId) : string
    {
        $jsonStringResponse = $this->mapper->replaceOrInsertFileByInstructionResult($request->getContent(), $instructionResultId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function getFileByInstructionResultId(Request $request, $instructionResultId) : string
    {
        $jsonStringResponse = $this->mapper->getFileByInstructionResultId($this->mapper->parse_query($request->getQueryString()), $instructionResultId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function updateFileByInstructionResultId(Request $request, $instructionResultId) : string
    {
        $jsonStringResponse = $this->mapper->updateFileFromInstructionResult($request->getContent(), $instructionResultId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    // instruction file link end

    // instruction stepLog link start

    public function insertStepLogByInstructionResultId(Request $request, $instructionResultId) : string
    {
        $jsonStringResponse = $this->mapper->insertStepLogAndLinkToInstructionResult($request->getContent(), $instructionResultId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function getStepLogByInstructionResultId(Request $request, $instructionResultId) : string
    {
        $jsonStringResponse = $this->mapper->getStepLogByInstructionResultId($this->mapper->parse_query($request->getQueryString()), $instructionResultId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function updateStepLogByInstructionResultId(Request $request, $instructionResultId) : string
    {
        $jsonStringResponse = $this->mapper->updateStepLogFromInstructionResult($request->getContent(), $instructionResultId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    // instruction stepLog link end

    // instruction executionLog link start

    public function insertExecutionLogByInstructionResultId(Request $request, $instructionResultId) : string
    {
        $jsonStringResponse = $this->mapper->insertExecutionLogAndLinkToInstructionResult($request->getContent(), $instructionResultId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function getExecutionLogByInstructionResultId(Request $request, $instructionResultId) : string
    {
        $jsonStringResponse = $this->mapper->getExecutionLogByInstructionResultId($this->mapper->parse_query($request->getQueryString()), $instructionResultId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function updateExecutionLogByInstructionResultId(Request $request, $instructionResultId) : string
    {
        $jsonStringResponse = $this->mapper->updateExecutionLogFromInstructionResult($request->getContent(), $instructionResultId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    // instruction executionLog link end

    // others start

    public function getRunByInstructionResultId(Request $request, $instructionResultId) : string
    {
        $jsonStringResponse = $this->mapper->getRunByInstructionResultId($this->mapper->parse_query($request->getQueryString()), $instructionResultId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    // others end
}
