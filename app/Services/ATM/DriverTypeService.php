<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:44
 */
namespace App\Services\ATM;

use App\Mappers\ATM\DriverTypeMapper;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DriverTypeService implements Service
{

    private $mapper;

    public function __construct()
    {
        $this->mapper = new DriverTypeMapper();
    }

    /**
     *
     * @SWG\Delete(
     * path="/api/driverTypes",
     * tags={"driverTypes resources"},
     * summary="删除DriverType",
     * operationId="deleteByCondition",
     * produces={"driverVendor/json"},
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
     * path="/api/driverTypes/{id}",
     * tags={"driverTypes resources"},
     * summary="删除单个DriverType",
     * operationId="deleteById",
     * produces={"driverVendor/json"},
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
     * path="/api/driverTypes",
     * tags={"driverTypes resources"},
     * summary="添加DriverType",
     * operationId="insert",
     * produces={"driverVendor/json"},
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
     * path="/api/driverTypes",
     * tags={"driverTypes resources"},
     * summary="读取DriverType",
     * operationId="selectByCondition",
     * produces={"driverVendor/json"},
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
     * path="/api/driverTypes/{id}",
     * tags={"driverTypes resources"},
     * summary="读取单个DriverType",
     * operationId="selectById",
     * produces={"driverVendor/json"},
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
     * path="/api/driverTypes",
     * tags={"driverTypes resources"},
     * summary="更新单个DriverType",
     * operationId="update",
     * produces={"driverVendor/json"},
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
     * path="/api/driverTypes",
     * tags={"driverTypes resources"},
     * summary="替换或添加DriverType",
     * operationId="replace",
     * produces={"driverVendor/json"},
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
     * path="/api/driverTypes/{driverTypeId}/driverVendors",
     * tags={"driverTypes resources"},
     * summary="获取关联于DriverType的DriverVendor",
     * operationId="getDriverVendorByDriverTypeId",
     * produces={"driverVendor/json"},
     * @SWG\Parameter(
     * name="driverTypeId ",
     * type="integer",
     * in="path",
     * required=true
     * ),
     * @SWG\Parameter(
     * name="name",
     * type="string",
     * in="query",
     * required=false,
     * description="DriverVendor Name，支持模糊搜索"
     * ),
     * @SWG\Parameter(
     * name="priority",
     * type="integer",
     * in="query",
     * required=false,
     * description="DriverVendor Priority，优先级"
     * ),
     * @SWG\Parameter(
     * name="type",
     * type="string",
     * in="query",
     * required=false,
     * description="DriverVendor Type，类型"
     * ),
     * @SWG\Parameter(
     * name="status",
     * type="string",
     * in="query",
     * required=false,
     * description="DriverVendor Status，状态"
     * ),
     * @SWG\Parameter(
     * name="startDate",
     * type="integer",
     * in="query",
     * required=false,
     * description="DriverVendor创建启示时间[unix second]"
     * ),
     * @SWG\Parameter(
     * name="endDate",
     * type="integer",
     * in="query",
     * required=false,
     * description="DriverVendor创建结束时间 [unix second]"
     * ),
     * @SWG\Response(
     * response="200",
     * description="NO MESSAGE"
     * ),
     * @SWG\Response(
     * response="400",
     * description="ID为“ + driverTypeId + ”的DriverType不存在。问题唯一码[“ + exuuid + ”]",
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
    // 关联接口
    public function getDriverVendorByDriverTypeId(Request $request, $driverTypeId) : string
    {
        $jsonStringResponse = $this->mapper->getDriverVendorByDriverTypeId($this->mapper->parse_query($request->getQueryString()), $driverTypeId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Delete(
     * path="/api/driverTypes/{driverTypeId}/driverVendors",
     * tags={"driverTypes resources"},
     * summary="获取关联于DriverType的DriverVendor",
     * operationId="deleteDriverVendorByDriverTypeId",
     * produces={"driverVendor/json"},
     * @SWG\Parameter(
     * name="driverTypeId ",
     * type="integer",
     * in="path",
     * required=true
     * ),
     * @SWG\Parameter(
     * name="ids ",
     * type="string",
     * in="query",
     * required=true,
     * description="Driver IDs, 逗号分隔"
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
     * description="输入中存在未关联到此DriverType的Driver。问题唯一码[“ + exuuid + ”]",
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
    public function deleteDriverVendorByDriverTypeId(Request $request, $driverTypeId) : string
    {
        $jsonStringResponse = $this->mapper->deleteDriverVendorsFromDriverType($this->mapper->parse_query($request->getQueryString()), $driverTypeId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Post(
     * path="/api/driverTypes/{driverTypeId}/driverVendors",
     * tags={"driverTypes resources"},
     * summary="添加单个或多个DriverVendor实体并链接到DriverType",
     * operationId="insertDriverVendorByDriverTypeId",
     * produces={"driverVendor/json"},
     * @SWG\Parameter(
     * name="driverTypeId",
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
     * description="ID为“ + driverTypeId + ”的DriverType不存在。问题唯一码[“ + exuuid + ”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Response(
     * response="403",
     * description="添加DriverVendor并连接到DriverType操作无法整体完成，请检查数据。并提供唯一码[“ + exuuid + ”]",
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
    public function insertDriverVendorByDriverTypeId(Request $request, $driverTypeId) : string
    {
        $jsonStringResponse = $this->mapper->insertDriverVendorsAndLinksToDriverType($request->getContent(), $driverTypeId);
        // convert the JSON string from response
        $body = json_encode($jsonStringResponse, JSON_UNESCAPED_UNICODE);
        return response($body, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

    /**
     *
     * @SWG\Put(
     * path="/api/driverTypes/{driverTypeId}/driverVendors",
     * tags={"driverTypes resources"},
     * summary="建立单个或多个DriverVendor到DriverType的链接",
     * operationId="replaceDriverVendorByDriverTypeId",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="driverTypeId",
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
     * description="DriverVendor IDs, 逗号分隔"
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
     * description="关联DriverVendor到DriverType的操作无法全部完成，错误IDs“+???+”请与管理员联系。并提供唯一码[“ + exuuid + ”]",
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
    public function replaceDriverVendorByDriverTypeId(Request $request, $driverTypeId) : string
    {
        $jsonStringResponse = $this->mapper->replaceOrInsertDriverVendorByDriverType($request->getContent(), $driverTypeId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Get(
     * path="/api/driverTypes/{driverTypeId}/drivers",
     * tags={"driverTypes resources"},
     * summary="获取关联于DriverType的Driver",
     * operationId="getDriverByDriverTypeId",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="driverTypeId ",
     * type="integer",
     * in="path",
     * required=true
     * ),
     * @SWG\Parameter(
     * name="name",
     * type="string",
     * in="query",
     * required=false,
     * description="Driver Name，支持模糊搜索"
     * ),
     * @SWG\Parameter(
     * name="priority",
     * type="integer",
     * in="query",
     * required=false,
     * description="Driver Priority，优先级"
     * ),
     * @SWG\Parameter(
     * name="type",
     * type="string",
     * in="query",
     * required=false,
     * description="Driver Type，类型"
     * ),
     * @SWG\Parameter(
     * name="status",
     * type="string",
     * in="query",
     * required=false,
     * description="Driver Status，状态"
     * ),
     * @SWG\Parameter(
     * name="startDate",
     * type="integer",
     * in="query",
     * required=false,
     * description="Driver创建启示时间[unix second]"
     * ),
     * @SWG\Parameter(
     * name="endDate",
     * type="integer",
     * in="query",
     * required=false,
     * description="Driver创建结束时间 [unix second]"
     * ),
     * @SWG\Response(
     * response="200",
     * description="NO MESSAGE"
     * ),
     * @SWG\Response(
     * response="400",
     * description="ID为“ + driverTypeId + ”的DriverType不存在。问题唯一码[“ + exuuid + ”]",
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
    public function getDriverByDriverTypeId(Request $request, $driverTypeId) : string
    {
        $jsonStringResponse = $this->mapper->getDriverByDriverTypeId($this->mapper->parse_query($request->getQueryString()), $driverTypeId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Delete(
     * path="/api/driverTypes/{driverTypeId}/drivers",
     * tags={"driverTypes resources"},
     * summary="获取关联于DriverType的Driver",
     * operationId="deleteDriverByDriverTypeId",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="driverTypeId ",
     * type="integer",
     * in="path",
     * required=true
     * ),
     * @SWG\Parameter(
     * name="ids ",
     * type="string",
     * in="query",
     * required=true,
     * description="Driver IDs, 逗号分隔"
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
     * description="输入中存在未关联到此DriverType的Driver。问题唯一码[“ + exuuid + ”]",
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
    public function deleteDriverByDriverTypeId(Request $request, $driverTypeId) : string
    {
        $jsonStringResponse = $this->mapper->deleteDriverFromDriverType($this->mapper->parse_query($request->getQueryString()), $driverTypeId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Post(
     * path="/api/driverTypes/{driverTypeId}/drivers",
     * tags={"driverTypes resources"},
     * summary="添加单个或多个Driver实体并链接到DriverType",
     * operationId="insertDriverByDriverTypeId",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="driverTypeId",
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
     * description="ID为“ + driverTypeId + ”的DriverType不存在。问题唯一码[“ + exuuid + ”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Response(
     * response="403",
     * description="添加Driver并连接到DriverType操作无法整体完成，请检查数据。并提供唯一码[“ + exuuid + ”]",
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
    public function insertDriverByDriverTypeId(Request $request, $driverTypeId) : string
    {
        $jsonStringResponse = $this->mapper->insertDriverAndLinkToDriverType($request->getContent(), $driverTypeId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Put(
     * path="/api/driverTypes/{driverTypeId}/drivers",
     * tags={"driverTypes resources"},
     * summary="建立单个或多个Driver到DriverType的链接",
     * operationId="replaceDriverByDriverTypeId",
     * produces={"application/json"},
     * @SWG\Parameter(
     * name="driverTypeId",
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
     * description="Driver IDs, 逗号分隔"
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
     * description="关联Driver到DriverType的操作无法全部完成，错误IDs“+???+”请与管理员联系。并提供唯一码[“ + exuuid + ”]",
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
    public function replaceDriverByDriverTypeId(Request $request, $driverTypeId) : string
    {
        $jsonStringResponse = $this->mapper->replaceOrInsertDriverByDriverType($request->getContent(), $driverTypeId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }
}
