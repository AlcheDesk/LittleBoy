<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:44
 */
namespace App\Services\ATM;

use App\Mappers\ATM\InstructionOverwriteMapper;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InstructionOverwriteService implements Service
{

    private $mapper;

    public function __construct()
    {
        $this->mapper = new InstructionOverwriteMapper();
    }

    /**
     *
     * @SWG\Delete(
     * path="/api/instructionOverwrites",
     * tags={"instructionOverwrites resources"},
     * summary="根据条件删除多个instructionOverwrite",
     * operationId="deleteByCondition",
     * produces={"instructionOverwrite/json"},
     * @SWG\Parameter(
     * name="ids",
     * type="string",
     * in="query",
     * ),
     * @SWG\Parameter(
     * name="name",
     * type="string",
     * in="query",
     * ),
     * @SWG\Parameter(
     * name="comment",
     * type="string",
     * in="query",
     * ),
     * @SWG\Parameter(
     * name="type",
     * type="string",
     * in="query",
     * ),
     * @SWG\Parameter(
     * name="log",
     * type="string",
     * in="query",
     * ),
     * @SWG\Response(
     * response="200",
     * description="请求成功"
     * )
     * )
     */
    public function deleteByCondition(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->deleteByOptions($this->mapper->parse_query($request->getQueryString()));
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Delete(
     * path="/api/instructionOverwrites/{id}",
     * tags={"instructionOverwrites resources"},
     * summary="删除单个instructionOverwrite",
     * operationId="deleteById",
     * produces={"instructionOverwrite/json"},
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
    public function deleteById(Request $request, $id) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->deleteById($id);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Post(
     * path="/api/instructionOverwrites",
     * tags={"instructionOverwrites resources"},
     * summary="添加instructionOverwrite",
     * operationId="insert",
     * produces={"instructionOverwrite/json"},
     * @SWG\Parameter(
     * name="body",
     * in="body",
     * @SWG\Schema(
     * type="array",
     * @SWG\Items(
     * ref="#/definitions/instructionOverwrite"
     * )
     * )
     * ),
     * @SWG\Response(
     * response="200",
     * description="请求成功"
     * )
     * )
     */
    public function insert(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->insert($request->getContent());
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Get(
     * path="/api/instructionOverwrites",
     * tags={"instructionOverwrites resources"},
     * summary="读取instructionOverwrites",
     * operationId="selectByCondition",
     * produces={"instructionOverwrite/json"},
     * @SWG\Parameter(
     * name="ids",
     * type="string",
     * in="query",
     * required=false,
     * ),
     * @SWG\Parameter(
     * name="name",
     * type="string",
     * in="query",
     * ),
     * @SWG\Parameter(
     * name="comment",
     * type="string",
     * in="query",
     * required=false,
     * ),
     * @SWG\Parameter(
     * name="type",
     * type="string",
     * in="query",
     * required=false,
     * ),
     * @SWG\Parameter(
     * name="type",
     * type="string",
     * in="query",
     * required=false,
     * ),
     * @SWG\Parameter(
     * name="startDate",
     * type="integer",
     * in="query",
     * required=false,
     * ),
     * @SWG\Parameter(
     * name="endDate",
     * type="integer",
     * in="query",
     * required=false,
     * ),
     * @SWG\Parameter(
     * name="log",
     * type="string",
     * in="query",
     * required=false,
     * ),
     * @SWG\Parameter(
     * name="orderBy",
     * type="string",
     * in="query",
     * required=false,
     * ),
     * @SWG\Response(
     * response="200",
     * description="NO MESSAGE"
     * ),
     * @SWG\Response(
     * response="500",
     * description="遇到系统内部错误 请与管理员联系。并提供错误唯一码[“+exuuid+”]。",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * )
     * )
     */
    public function selectByCondition(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->selectByOptions($this->mapper->parse_query($request->getQueryString()));
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Get(
     * path="/api/instructionOverwrites/{id}",
     * tags={"instructionOverwrites resources"},
     * summary="读取单个instructionOverwrite",
     * operationId="selectById",
     * produces={"instructionOverwrite/json"},
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
    public function selectById(Request $request, $id) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->selectById($this->mapper->parse_query($request->getQueryString()), $id);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Patch(
     * path="/api/instructionOverwrites",
     * tags={"instructionOverwrites resources"},
     * summary="更新instructionOverwrite",
     * operationId="update",
     * produces={"instructionOverwrite/json"},
     * @SWG\Parameter(
     * name="body",
     * in="body",
     * @SWG\Schema(
     * type="array",
     * @SWG\Items(
     * ref="#/definitions/instructionOverwrite"
     * )
     * )
     * ),
     * @SWG\Response(
     * response="200",
     * description="请求成功"
     * )
     * )
     */
    public function update(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->update($request->getContent());
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Put(
     * path="/api/instructionOverwrites",
     * tags={"instructionOverwrites resources"},
     * summary="替换或添加instructionOverwrite,要求id为已存在的instructionOverwriteId",
     * operationId="replace",
     * produces={"instructionOverwrite/json"},
     * @SWG\Parameter(
     * name="body",
     * in="body",
     * @SWG\Schema(
     * type="array",
     * @SWG\Items(
     * ref="#/definitions/instructionOverwrite"
     * )
     * )
     * ),
     * @SWG\Response(
     * response="200",
     * description="请求成功"
     * )
     * )
     */
    public function replace(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->replace($request->getContent());
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    // 关联接口
    /**
     *
     * @SWG\Get(
     * path="/api/instructionOverwrites/{instructionOverwriteId}/testCaseOverwrites",
     * tags={"instructionOverwrites resources"},
     * summary="根据instructionOverwriteId获取testCaseOverwrites",
     * operationId="getTestCaseOverwriteByInstructionOverwriteId",
     * produces={"instructionOverwrite/json"},
     * @SWG\Parameter(
     * name="instructionOverwriteId",
     * in="path",
     * type="integer",
     * required=true,
     * ),
     * @SWG\Response(
     * response="200",
     * description="请求成功"
     * )
     * )
     */
    public function getTestCaseOverwriteByInstructionOverwriteId(Request $request, $instructionOverwriteId) : string
    {
        $jsonStringResponse = $this->mapper->getTestCaseOverwriteByInstructionOverwriteId($this->mapper->parse_query($request->getQueryString()), $instructionOverwriteId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }
}
