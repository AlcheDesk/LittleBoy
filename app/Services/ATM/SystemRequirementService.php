<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:44
 */
namespace App\Services\ATM;

use App\Mappers\ATM\SystemRequirementMapper;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SystemRequirementService implements Service
{

    private $mapper;

    public function __construct()
    {
        $this->mapper = new SystemRequirementMapper();
    }

    /**
     *
     * @SWG\Delete(
     * path="/api/systemRequirements",
     * tags={"systemRequirements resources"},
     * summary="删除SystemRequirement",
     * operationId="deleteByCondition",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="ids",
     * type="string",
     * in="query",
     * required=false,
     * description="ids"
     * ),
     * @SWG\Parameter(
     * name="name",
     * type="string",
     * in="query",
     * description="name"
     * ),
     * @SWG\Parameter(
     * name="comment",
     * type="string",
     * in="query",
     * required=false,
     * description="comment"
     * ),
     * @SWG\Parameter(
     * name="type",
     * type="string",
     * in="query",
     * required=false,
     * description="type"
     * ),
     * @SWG\Parameter(
     * name="type",
     * type="string",
     * in="query",
     * required=false,
     * description="type"
     * ),
     * @SWG\Parameter(
     * name="startDate",
     * type="integer",
     * in="query",
     * required=false,
     * description="startDat[unix second]"
     * ),
     * @SWG\Parameter(
     * name="endDate",
     * type="integer",
     * in="query",
     * required=false,
     * description="endDate[unix second]"
     * ),
     * @SWG\Parameter(
     * name="log",
     * type="string",
     * in="query",
     * required=false,
     * description="log(case-sensitive)"
     * ),
     * @SWG\Parameter(
     * name="orderBy",
     * type="string",
     * in="query",
     * required=false,
     * description="orderBy"
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
     * path="/api/systemRequirements/{id}",
     * tags={"systemRequirements resources"},
     * summary="删除单个SystemRequirement",
     * operationId="deleteById",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="id",
     * type="integer",
     * in="path",
     * required=true
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
     * path="/api/systemRequirements",
     * tags={"systemRequirements resources"},
     * summary="添加SystemRequirement",
     * operationId="insert",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="body",
     * in="body",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Response(
     * response="200",
     * description="NO MESSAGE"
     * ),
     * @SWG\Response(
     * response="400",
     * description="添加操作无法完成，请与管理员联系。并提供唯一码[“+exuuid+”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Response(
     * response="500",
     * description="遇到系统内部错误 请与管理员联系。并提供错误唯一码[“+exuuid+”]。"
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
     * path="/api/systemRequirements",
     * tags={"systemRequirements resources"},
     * summary="读取SystemRequirement",
     * operationId="selectByCondition",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="ids",
     * type="string",
     * in="query",
     * required=false,
     * description="ids"
     * ),
     * @SWG\Parameter(
     * name="name",
     * type="string",
     * in="query",
     * description="name"
     * ),
     * @SWG\Parameter(
     * name="comment",
     * type="string",
     * in="query",
     * required=false,
     * description="comment"
     * ),
     * @SWG\Parameter(
     * name="type",
     * type="string",
     * in="query",
     * required=false,
     * description="type"
     * ),
     * @SWG\Parameter(
     * name="type",
     * type="string",
     * in="query",
     * required=false,
     * description="type"
     * ),
     * @SWG\Parameter(
     * name="startDate",
     * type="integer",
     * in="query",
     * required=false,
     * description="startDat[unix second]"
     * ),
     * @SWG\Parameter(
     * name="endDate",
     * type="integer",
     * in="query",
     * required=false,
     * description="endDate[unix second]"
     * ),
     * @SWG\Parameter(
     * name="log",
     * type="string",
     * in="query",
     * required=false,
     * description="log(case-sensitive)"
     * ),
     * @SWG\Parameter(
     * name="orderBy",
     * type="string",
     * in="query",
     * required=false,
     * description="orderBy"
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
     * path="/api/systemRequirements/{id}",
     * tags={"systemRequirements resources"},
     * summary="读取单个SystemRequirement",
     * operationId="selectById",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="id",
     * type="integer",
     * in="path",
     * required=true
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
     * path="/api/systemRequirements",
     * tags={"systemRequirements resources"},
     * summary="更新单个SystemRequirement",
     * operationId="update",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="body",
     * in="body",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Parameter(
     * name="ids",
     * type="string",
     * in="query",
     * required=false,
     * description="ids"
     * ),
     * @SWG\Parameter(
     * name="name",
     * type="string",
     * in="query",
     * description="name"
     * ),
     * @SWG\Parameter(
     * name="comment",
     * type="string",
     * in="query",
     * required=false,
     * description="comment"
     * ),
     * @SWG\Parameter(
     * name="type",
     * type="string",
     * in="query",
     * required=false,
     * description="type"
     * ),
     * @SWG\Parameter(
     * name="type",
     * type="string",
     * in="query",
     * required=false,
     * description="type"
     * ),
     * @SWG\Parameter(
     * name="startDate",
     * type="integer",
     * in="query",
     * required=false,
     * description="startDat[unix second]"
     * ),
     * @SWG\Parameter(
     * name="endDate",
     * type="integer",
     * in="query",
     * required=false,
     * description="endDate[unix second]"
     * ),
     * @SWG\Parameter(
     * name="orderBy",
     * type="string",
     * in="query",
     * required=false,
     * description="orderBy"
     * ),
     * @SWG\Response(
     * response="200",
     * description="NO MESSAGE"
     * ),
     * @SWG\Response(
     * response="400",
     * description="添加操作无法完成，请与管理员联系。并提供唯一码[“+exuuid+”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Response(
     * response="403",
     * description="添加操作无法完成，请与管理员联系。并提供唯一码[“+exuuid+”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Response(
     * response="500",
     * description="遇到系统内部错误 请与管理员联系。并提供错误唯一码[“+exuuid+”]。"
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
     * path="/api/systemRequirements",
     * tags={"systemRequirements resources"},
     * summary="替换或添加SystemRequirement",
     * operationId="replace",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="body",
     * in="body",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Response(
     * response="200",
     * description="NO MESSAGE"
     * ),
     * @SWG\Response(
     * response="400",
     * description="添加操作无法完成，请与管理员联系。并提供唯一码[“+exuuid+”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Response(
     * response="403",
     * description="添加操作无法完成，请与管理员联系。并提供唯一码[“+exuuid+”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Response(
     * response="500",
     * description="遇到系统内部错误 请与管理员联系。并提供错误唯一码[“+exuuid+”]。"
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

    /**
     *
     * @SWG\Get(
     * path="/api/systemRequirements/{systemRequirementId}/testCases",
     * tags={"systemRequirements resources"},
     * summary="读取SystemRequirement关联的TestCase",
     * operationId="getTestCaseBySystemRequirementId",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="systemRequirementId",
     * type="integer",
     * in="path",
     * required=true
     * ),
     * @SWG\Parameter(
     * name="names",
     * type="string",
     * in="query",
     * description="name"
     * ),
     * @SWG\Parameter(
     * name="priority",
     * type="integer",
     * in="query",
     * description="task priority"
     * ),
     * @SWG\Parameter(
     * name="type",
     * type="integer",
     * in="query",
     * description="task UUID"
     * ),
     * @SWG\Parameter(
     * name="status",
     * type="string",
     * in="query",
     * description="task status [ALL UPPER CASE]"
     * ),
     * @SWG\Parameter(
     * name="startDate",
     * type="integer",
     * in="query",
     * description="start date [unix second]"
     * ),
     * @SWG\Parameter(
     * name="endDate",
     * type="integer",
     * in="query",
     * description="end date [unix second]"
     * ),
     * @SWG\Response(
     * response="200",
     * description="NO MESSAGE"
     * ),
     * @SWG\Response(
     * response="400",
     * description="添加操作无法完成，请与管理员联系。并提供唯一码[“+exuuid+”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Response(
     * response="403",
     * description="添加操作无法完成，请与管理员联系。并提供唯一码[“+exuuid+”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Response(
     * response="500",
     * description="遇到系统内部错误 请与管理员联系。并提供错误唯一码[“+exuuid+”]。"
     * )
     * )
     */
    // 关联接口
    public function getTestCaseBySystemRequirementId(Request $request, $systemRequirementId) : string
    {
        $jsonStringResponse = $this->mapper->getTestCaseBySystemRequirementId($this->mapper->parse_query($request->getQueryString()), $systemRequirementId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }
}
