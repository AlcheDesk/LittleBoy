<?php
/**
 * User: tryndamere.wang
 * Date: 2018/12/20
 * Time: 10:39
 */
namespace App\Services\ATM;

use App\Mappers\ATM\StatusReportMapper;
use App\Services\Utils\RedisUtils\ATM\StatusReportProjectRedisUtilService;
use App\Services\Utils\RedisUtils\ATM\StatusReportTestCaseRedisUtilService;
use App\Services\Utils\RedisUtils\ATM\StatusReportRunSetRedisUtilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StatusReportService
{

    private $mapper;
    private $statusReportProjectRedisUtilService;
    private $statusReportTestCaseRedisUtilService;
    private $statusReportRunSetRedisUtilService;

    public function __construct()
    {
        $this->mapper = new StatusReportMapper();
        $this->statusReportProjectRedisUtilService = new StatusReportProjectRedisUtilService();
        $this->statusReportTestCaseRedisUtilService = new StatusReportTestCaseRedisUtilService();
        $this->statusReportRunSetRedisUtilService = new StatusReportRunSetRedisUtilService();
    }

    public function getStatusReportProject(Request $request) : string
    {
        if($this->statusReportProjectRedisUtilService->hasRecordList($request->getQueryString())){
            $jsonStringResponse = $this->statusReportProjectRedisUtilService->getRecordListFromCache($request->getQueryString());
        }else{
            $jsonStringResponse = $this->mapper->getStatusReportProject($this->mapper->parse_query($request->getQueryString()));
            $this->statusReportProjectRedisUtilService->cacheRecordList($request->getQueryString(),$jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function getStatusReportProjectById(Request $request, $projectId) : string
    {
        if($this->statusReportProjectRedisUtilService->hasRecord($projectId)){
            $jsonStringResponse = $this->statusReportProjectRedisUtilService->getRecordFromCache($projectId);
        }else{
            $jsonStringResponse = $this->mapper->getStatusReportProjectById($this->mapper->parse_query($request->getQueryString()), $projectId);
            $this->statusReportProjectRedisUtilService->cacheRecord($projectId, $jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function getStatusReportTestCaseByProjectId(Request $request, $projectId) : string
    {
        if($this->statusReportTestCaseRedisUtilService->hasRecordList('projectId='.$projectId.'_'.$request->getQueryString())){
            $jsonStringResponse =  $this->statusReportTestCaseRedisUtilService->getRecordListFromCache('projectId='.$projectId.'_'.$request->getQueryString());
        }else{
            $jsonStringResponse = $this->mapper->getStatusReportTestCaseByProjectId($this->mapper->parse_query($request->getQueryString()), $projectId);
            $this->statusReportTestCaseRedisUtilService->cacheRecordList('projectId='.$projectId.'_'.$request->getQueryString(),$jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function getStatusReportRunSet(Request $request) : string
    {
        if($this->statusReportRunSetRedisUtilService->hasRecordList($request->getQueryString())){
            $jsonStringResponse = $this->statusReportRunSetRedisUtilService->getRecordListFromCache($request->getQueryString());
        }else{
            $jsonStringResponse = $this->mapper->getStatusReportRunSet($this->mapper->parse_query($request->getQueryString()));
            $this->statusReportRunSetRedisUtilService->cacheRecordList($request->getQueryString(),$jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function getStatusReportRunSetById(Request $request, $runSetId) : string
    {
        if($this->statusReportRunSetRedisUtilService->hasRecord($runSetId)){
            $jsonStringResponse = $this->statusReportRunSetRedisUtilService->getRecordFromCache($runSetId);
        }else{
            $jsonStringResponse = $this->mapper->getStatusReportRunSetById($this->mapper->parse_query($request->getQueryString()), $runSetId);
            $this->statusReportRunSetRedisUtilService->cacheRecord($runSetId, $jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function getStatusReportTestCaseByRunSetId(Request $request, $runSetId) : string
    {
        if($this->statusReportTestCaseRedisUtilService->hasRecordList('runSetId='.$runSetId.'_'.$request->getQueryString())){
            $jsonStringResponse =  $this->statusReportTestCaseRedisUtilService->getRecordListFromCache('runSetId='.$runSetId.'_'.$request->getQueryString());
        }else{
            $jsonStringResponse = $this->mapper->getStatusReportTestCaseByRunSetId($this->mapper->parse_query($request->getQueryString()), $runSetId);
            $this->statusReportTestCaseRedisUtilService->cacheRecordList('runSetId='.$runSetId.'_'.$request->getQueryString(),$jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function getStatusReportTestCase(Request $request) : string
    {
        if($this->statusReportTestCaseRedisUtilService->hasRecordList($request->getQueryString())){
            $jsonStringResponse = $this->statusReportTestCaseRedisUtilService->getRecordListFromCache($request->getQueryString());
        }else{
            $jsonStringResponse = $this->mapper->getStatusReportTestCase($this->mapper->parse_query($request->getQueryString()));
            $this->statusReportTestCaseRedisUtilService->cacheRecordList($request->getQueryString(),$jsonStringResponse);
        }
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }
}
