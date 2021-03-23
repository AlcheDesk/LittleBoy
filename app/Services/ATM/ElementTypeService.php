<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:44
 */
namespace App\Services\ATM;

use App\Mappers\ATM\ElementTypeMapper;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ElementTypeService implements Service
{

    private $mapper;

    public function __construct()
    {
        $this->mapper = new ElementTypeMapper();
    }

    /**
     *
     * @SWG\Delete(
     * path="/api/elementTypes",
     * tags={"elementTypes resources"},
     * summary="删除ElementType",
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
     * path="/api/elementTypes/{id}",
     * tags={"elementTypes resources"},
     * summary="删除单个ElementType",
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
     * path="/api/elementTypes",
     * tags={"elementTypes resources"},
     * summary="添加ElementType",
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
     * path="/api/elementTypes",
     * tags={"elementTypes resources"},
     * summary="读取ElementType",
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
     * path="/api/elementTypes/{id}",
     * tags={"elementTypes resources"},
     * summary="读取单个ElementType",
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
     * path="/api/elementTypes",
     * tags={"elementTypes resources"},
     * summary="更新单个ElementType",
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
     * path="/api/elementTypes",
     * tags={"elementTypes resources"},
     * summary="替换或添加ElementType",
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
     * path="/api/elementTypes/{elementTypeId}/elementActions",
     * tags={"elementTypes resources"},
     * summary="获取关联于ElementType的ElementAction",
     * operationId="getInstructionActionByElementTypeId",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="elementTypeId ",
     * type="integer",
     * in="path",
     * required=true
     * ),
     * @SWG\Parameter(
     * name="name",
     * type="string",
     * in="query",
     * description="ElementAction Name，支持模糊搜索"
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
    // 关联接口
    public function getInstructionActionByElementTypeId(Request $request, $elementTypeId) : string
    {
        $jsonStringResponse = $this->mapper->getInstructionActionByElementTypeId($this->mapper->parse_query($request->getQueryString()), $elementTypeId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Delete(
     * path="/api/elementTypes/{elementTypeId}/elementActionsons",
     * tags={"elementTypes resources"},
     * summary="删除关联到ElementType的ElementAction",
     * operationId="deleteInstructionActionByElementTypeId",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="elementTypeId",
     * type="integer",
     * in="path",
     * required=true
     * ),
     * @SWG\Parameter(
     * name="ids ",
     * type="string",
     * in="query",
     * required=true,
     * description="ElementAction IDs, 逗号分隔"
     * ),
     * @SWG\Response(
     * response="200",
     * description="NO MESSAGE"
     * ),
     * @SWG\Response(
     * response="400",
     * description="部分或全部ID不存在对应的ElementAction",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Response(
     * response="404",
     * description="输入中存在未关联到此ElementType的ElementAction。问题唯一码[“ + exuuid + ”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
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
    public function deleteInstructionActionByElementTypeId(Request $request, $elementTypeId) : string
    {
        $jsonStringResponse = $this->mapper->deleteInstructionActionByElementTypeId($elementTypeId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Post(
     * path="/api/elementTypes/{elementTypeId}/elementActions",
     * tags={"elementTypes resources"},
     * summary="添加单个或多个ElementAction实体并链接到ElementType",
     * operationId="insertInstructionActionByElementTypeId",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="elementTypeId ",
     * type="integer",
     * in="path",
     * required=true
     * ),
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
     * description="ID为“ + elementTypeId + ”的ElementType不存在。问题唯一码[“ + exuuid + ”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Response(
     * response="403",
     * description="添加ElementAction并连接到ElementType操作无法整体完成，请检查数据。并提供唯一码[“ + exuuid + ”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
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
    public function insertInstructionActionByElementTypeId(Request $request, $elementTypeId) : string
    {
        $jsonStringResponse = $this->mapper->insertInstructionActionByElementTypeId($request->getContent(), $elementTypeId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Put(
     * path="/api/elementTypes/{elementTypeId}/elementActions",
     * tags={"elementTypes resources"},
     * summary="建立单个或多个ElementAction到ElementType的链接",
     * operationId="replaceInstructionActionByElementTypeId",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="elementTypeId ",
     * type="integer",
     * in="path",
     * required=true
     * ),
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
     * required=true,
     * description="ElementAction IDs, 逗号分隔"
     * ),
     * @SWG\Response(
     * response="200",
     * description="NO MESSAGE"
     * ),
     * @SWG\Response(
     * response="400",
     * description="ids格式不正确。第一个ids为有效输入，且只能为逗号分隔整数形式，第一个ids为有效输入。问题唯一码[“ + exuuid + ”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Response(
     * response="403",
     * description="关联Application到Project的操作无法全部完成，错误IDs“+???+”请与管理员联系。并提供唯一码[“ + exuuid + ”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
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
    public function replaceInstructionActionByElementTypeId(Request $request, $elementTypeId) : string
    {
        $jsonStringResponse = $this->mapper->replaceInstructionActionByElementTypeId($request->getContent(), $elementTypeId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Get(
     * path="/api/elementTypes/{elementTypeId}/elementLocatorTypes",
     * tags={"elementTypes resources"},
     * summary="获取关联于ElementType的ElementLocatorType",
     * operationId="getElementLocatorTypeByElementTypeId",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="elementTypeId ",
     * type="integer",
     * in="path",
     * required=true
     * ),
     * @SWG\Parameter(
     * name="name",
     * type="string",
     * in="query",
     * required=false,
     * description="ElementLocatorType Name，支持模糊搜索"
     * ),
     * @SWG\Response(
     * response="200",
     * description="NO MESSAGE"
     * ),
     * @SWG\Response(
     * response="400",
     * description="ID为“ + projectId + ”的Project不存在。问题唯一码[“ + exuuid + ”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
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
    public function getElementLocatorTypeByElementTypeId(Request $request, $elementTypeId) : string
    {
        $jsonStringResponse = $this->mapper->getElementLocatorTypeByElementTypeId($this->mapper->parse_query($request->getQueryString()), $elementTypeId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Delete(
     * path="/api/elementTypes/{elementTypeId}/elementLocatorTypes",
     * tags={"elementTypes resources"},
     * summary="删除关联到ElementType的ElementLocatorType",
     * operationId="deleteElementLocatorTypeByElementTypeId",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="elementTypeId ",
     * type="integer",
     * in="path",
     * required=true
     * ),
     * @SWG\Parameter(
     * name="ids ",
     * type="string",
     * in="query",
     * required=true,
     * description="ElementLocatorType IDs, 逗号分隔"
     * ),
     * @SWG\Response(
     * response="200",
     * description="NO MESSAGE"
     * ),
     * @SWG\Response(
     * response="400",
     * description="ids格式不正确。第一个ids为有效输入，且只能为逗号分隔整数形式，第一个ids为有效输入。问题唯一码[“ + exuuid + ”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Response(
     * response="404",
     * description="输入中存在未关联到此ElementType的ElementLocatorType。问题唯一码[“ + exuuid + ”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
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
    public function deleteElementLocatorTypeByElementTypeId(Request $request, $elementTypeId) : string
    {
        $jsonStringResponse = $this->mapper->deleteElementLocatorTypeFromElementType($elementTypeId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Post(
     * path="/api/elementTypes/{elementTypeId}/elementLocatorTypes",
     * tags={"elementTypes resources"},
     * summary="添加单个或多个ElementLocatorType实体并链接到ElementType",
     * operationId="insertElementLocatorTypes/projects/{projectId}/testCaseByElementTypeId",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="elementTypeId",
     * type="integer",
     * in="path",
     * required=true
     * ),
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
     * response="403",
     * description="添加TestCase并连接到Project操作无法整体完成，请检查数据。并提供唯一码[“ + exuuid + ”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
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
    public function insertElementLocatorTypeByElementTypeId(Request $request, $elementTypeId) : string
    {
        $jsonStringResponse = $this->mapper->insertElementLocatorTypeAndLinkToElementType($request->getContent(), $elementTypeId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Put(
     * path="/api/elementTypes/{elementTypeId}/elementLocatorTypes",
     * tags={"elementTypes resources"},
     * summary="建立单个或多个ElementLocatorType到ElementType的链接",
     * operationId="replaceElementLocatorTypeByElementTypeId",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="elementTypeId",
     * type="integer",
     * in="path",
     * required=true
     * ),
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
     * required=true,
     * description="ElementLocatorType IDs, 逗号分隔"
     * ),
     * @SWG\Response(
     * response="200",
     * description="NO MESSAGE"
     * ),
     * @SWG\Response(
     * response="400",
     * description="ids格式不正确。第一个ids为有效输入，且只能为逗号分隔整数形式，第一个ids为有效输入。问题唯一码[“ + exuuid + ”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Response(
     * response="403",
     * description="关联ElementLocatorType到ElementType的操作无法全部完成，错误IDs“+???+”请与管理员联系。并提供唯一码[“ + exuuid + ”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
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
    public function replaceElementLocatorTypeByElementTypeId(Request $request, $elementTypeId) : string
    {
        $jsonStringResponse = $this->mapper->replaceElementLocatorTypeByElementTypeId($request->getContent(), $elementTypeId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Get(
     * path="/api/elementTypes/{elementTypeId}/instructionOptions",
     * tags={"elementTypes resources"},
     * summary="getInstructionOptionsTypeByElementTypeId",
     * operationId="getInstructionOptionsTypeByElementTypeId",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="elementTypeId ",
     * type="integer",
     * in="path",
     * required=true
     * ),
     * @SWG\Parameter(
     * name="name",
     * type="string",
     * in="query",
     * required=false,
     * description="InstructionOption Name，支持模糊搜索"
     * ),
     * @SWG\Response(
     * response="200",
     * description="NO MESSAGE"
     * ),
     * @SWG\Response(
     * response="400",
     * description="ID为“ + elementTypeId + ”的ElementType不存在。问题唯一码[“ + exuuid + ”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
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
    public function getInstructionOptionsTypeByElementTypeId(Request $request, $elementTypeId) : string
    {
        $jsonStringResponse = $this->mapper->getInstructionOptionByElementTypeId($this->mapper->parse_query($request->getQueryString()), $elementTypeId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Delete(
     * path="/api/elementTypes/{elementTypeId}/instructionOptions",
     * tags={"elementTypes resources"},
     * summary="删除关联到ElementType的InstructionOption",
     * operationId="deleteInstructionOptionsTypeByElementTypeId",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="elementTypeId ",
     * type="integer",
     * in="path",
     * required=true
     * ),
     * @SWG\Parameter(
     * name="ids ",
     * type="string",
     * in="query",
     * required=true,
     * description="InstructionOption IDs, 逗号分隔"
     * ),
     * @SWG\Response(
     * response="200",
     * description="NO MESSAGE"
     * ),
     * @SWG\Response(
     * response="400",
     * description="部分或全部ID不存在对应的InstructionOption",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Response(
     * response="404",
     * description="输入中存在未关联到此ElementType的InstructionOption。问题唯一码[“ + exuuid + ”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
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
    public function deleteInstructionOptionsTypeByElementTypeId(Request $request, $elementTypeId) : string
    {
        $jsonStringResponse = $this->mapper->deleteInstructionOptionFromElementType($elementTypeId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Post(
     * path="/api/elementTypes/{elementTypeId}/instructionOptions",
     * tags={"elementTypes resources"},
     * summary="添加单个或多个InstructionOption实体并链接到ElementType",
     * operationId="insertInstructionOptionsTypeByElementTypeId",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="elementTypeId",
     * type="integer",
     * in="path",
     * required=true
     * ),
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
     * description="ID为“ + elementTypeId + ”的ElementType不存在。问题唯一码[“ + exuuid + ”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Response(
     * response="403",
     * description="添加InstructionOption并连接到ElementType操作无法整体完成，请检查数据。并提供唯一码[“ + exuuid + ”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
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
    public function insertInstructionOptionsTypeByElementTypeId(Request $request, $elementTypeId) : string
    {
        $jsonStringResponse = $this->mapper->insertInstructionOptionAndLinkToElementType($request->getContent(), $elementTypeId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Put(
     * path="/api/elementTypes/{elementTypeId}/instructionOptions",
     * tags={"elementTypes resources"},
     * summary="建立单个或多个InstructionOption到ElementType的链接",
     * operationId="replaceInstructionOptionsTypeByElementTypeId",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="elementTypeId",
     * type="integer",
     * in="path",
     * required=true
     * ),
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
     * required=true,
     * description="InstructionOption IDs, 逗号分隔"
     * ),
     * @SWG\Response(
     * response="200",
     * description="NO MESSAGE"
     * ),
     * @SWG\Response(
     * response="400",
     * description="ids格式不正确。第一个ids为有效输入，且只能为逗号分隔整数形式，第一个ids为有效输入。问题唯一码[“ + exuuid + ”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Response(
     * response="403",
     * description="关联InstructionOption到ElementType的操作无法全部完成，错误IDs“+???+”请与管理员联系。并提供唯一码[“ + exuuid + ”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
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
    public function replaceInstructionOptionByElementTypeId(Request $request, $elementTypeId) : string
    {
        $jsonStringResponse = $this->mapper->replaceOrInsertInstructionOptionByElementType($request->getContent(), $elementTypeId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Get(
     * path="/api/elementTypes/{elementTypeId}/elements",
     * tags={"elementTypes resources"},
     * summary="读取ElementType关联的Element",
     * operationId="getElementByElementTypeId",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="elementTypeId ",
     * type="integer",
     * in="path",
     * required=true
     * ),
     * @SWG\Parameter(
     * name="name",
     * type="string",
     * in="query",
     * required=false,
     * description="name"
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
    public function getElementByElementTypeId(Request $request, $elementTypeId) : string
    {
        $jsonStringResponse = $this->mapper->getElementByElementTypeId($this->mapper->parse_query($request->getQueryString()), $elementTypeId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }
}
