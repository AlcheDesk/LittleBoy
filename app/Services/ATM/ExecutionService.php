<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:44
 */
namespace App\Services\ATM;

use App\Mappers\ATM\ExecutionMapper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExecutionService
{

    private $mapper;

    public function __construct()
    {
        $this->mapper = new ExecutionMapper();
    }

    /**
     *
     * @SWG\Post(
     * path="/api/applications",
     * tags={"applications resources"},
     * summary="添加application",
     * operationId="insert",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="body",
     * in="body",
     * @SWG\Schema(
     * type="array",
     * @SWG\Items(
     * ref="#/definitions/application"
     * )
     * )
     * ),
     * @SWG\Response(
     * response="200",
     * description="请求成功"
     * )
     * )
     */
    public function executeTestCaseByTestCaseId(Request $request, $testCaseId) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->executeTestCaseByTestCaseId($request->getContent(), $testCaseId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function executeDryRunTestCaseByTestCaseId(Request $request, $testCaseId) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->executeDryRunTestCaseByTestCaseId($request->getContent(), $testCaseId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Get(
     * path="/api/applications/{id}",
     * tags={"applications resources"},
     * summary="读取单个application",
     * operationId="selectById",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="id",
     * type="integer",
     * in="path",
     * required=true,
     * ),
     * @SWG\Response(
     * response="200",
     * description="请求成功"
     * )
     * )
     */
    public function selectExecuteTestCaseByTestCaseId(Request $request, $id) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->selectExecuteTestCaseByTestCaseId($this->mapper->parse_query($request->getQueryString()), $id);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Post(
     * path="/api/applications",
     * tags={"applications resources"},
     * summary="添加application",
     * operationId="insert",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="body",
     * in="body",
     * @SWG\Schema(
     * type="array",
     * @SWG\Items(
     * ref="#/definitions/application"
     * )
     * )
     * ),
     * @SWG\Response(
     * response="200",
     * description="请求成功"
     * )
     * )
     */
    public function executeRunSetByRunSetId(Request $request, $runSetId) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->executeRunSetByRunSetId($request->getContent(), $runSetId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Get(
     * path="/api/applications/{id}",
     * tags={"applications resources"},
     * summary="读取单个application",
     * operationId="selectById",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="id",
     * type="integer",
     * in="path",
     * required=true,
     * ),
     * @SWG\Response(
     * response="200",
     * description="请求成功"
     * )
     * )
     */
    public function selectExecuteRunSetByRunSetId(Request $request, $id) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->selectExecuteRunSetByRunSetId($this->mapper->parse_query($request->getQueryString()), $id);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function executeRunSetResultByRunSetId(Request $request, $id) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->executeRunSetResultByRunSetId($request->getContent(), $id);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function executeAliases(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->executeAliases($request->getContent());
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }
}
