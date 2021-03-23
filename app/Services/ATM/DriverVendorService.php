<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:44
 */
namespace App\Services\ATM;

use App\Mappers\ATM\DriverVendorMapper;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DriverVendorService implements Service
{

    private $mapper;

    public function __construct()
    {
        $this->mapper = new DriverVendorMapper();
    }

    /**
     *
     * @SWG\Delete(
     * path="/api/driverVendors",
     * tags={"driverVendors resources"},
     * summary="删除DriverVendor",
     * operationId="deleteByCondition",
     * produces={"driverProperty/json"},
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
     * path="/api/driverVendors/{id}",
     * tags={"driverVendors resources"},
     * summary="删除单个DriverVendor",
     * operationId="deleteById",
     * produces={"driverProperty/json"},
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
     * path="/api/driverVendors",
     * tags={"driverVendors resources"},
     * summary="添加DriverVendor",
     * operationId="insert",
     * produces={"driverProperty/json"},
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
     * path="/api/driverVendors",
     * tags={"driverVendors resources"},
     * summary="读取DriverVendor",
     * operationId="selectByCondition",
     * produces={"driverProperty/json"},
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
     * path="/api/driverVendors/{id}",
     * tags={"driverVendors resources"},
     * summary="读取单个DriverVendor",
     * operationId="selectById",
     * produces={"driverProperty/json"},
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
     * path="/api/driverVendors",
     * tags={"driverVendors resources"},
     * summary="更新单个DriverVendor",
     * operationId="update",
     * produces={"driverProperty/json"},
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
     * path="/api/driverVendors",
     * tags={"driverVendors resources"},
     * summary="替换或添加DriverVendor",
     * operationId="replace",
     * produces={"driverProperty/json"},
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
     * path="/api/driverVendors/{driverVendorId}/driverProperties",
     * tags={"driverVendors resources"},
     * summary="获取关联于DriverVendor的DriverProperty",
     * operationId="getDriverPropertyByDriverVendorId",
     * produces={"driverProperty/json"},
     * @SWG\Parameter(
     * name="driverVendorId ",
     * type="integer",
     * in="path",
     * required=true
     * ),
     * @SWG\Parameter(
     * name="name",
     * type="string",
     * in="query",
     * required=false,
     * description="DriverProperty Name，支持模糊搜索"
     * ),
     * @SWG\Parameter(
     * name="priority",
     * type="integer",
     * in="query",
     * required=false,
     * description="DriverProperty Priority，优先级"
     * ),
     * @SWG\Parameter(
     * name="type",
     * type="string",
     * in="query",
     * required=false,
     * description="DriverProperty Type，类型"
     * ),
     * @SWG\Parameter(
     * name="status",
     * type="string",
     * in="query",
     * required=false,
     * description="DriverProperty Status，状态"
     * ),
     * @SWG\Parameter(
     * name="startDate",
     * type="integer",
     * in="query",
     * required=false,
     * description="DriverProperty创建启示时间[unix second]"
     * ),
     * @SWG\Parameter(
     * name="endDate",
     * type="integer",
     * in="query",
     * required=false,
     * description="DriverProperty创建结束时间 [unix second]"
     * ),
     * @SWG\Response(
     * response="200",
     * description="NO MESSAGE"
     * ),
     * @SWG\Response(
     * response="400",
     * description="ID为“ + driverVendorId + ”的DriverVendor不存在。问题唯一码[“ + exuuid + ”]",
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
    public function getDriverPropertyByDriverVendorId(Request $request, $driverVendorId) : string
    {
        $jsonStringResponse = $this->mapper->getDriverPropertyByDriverVendorId($this->mapper->parse_query($request->getQueryString()), $driverVendorId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Delete(
     * path="/api/driverVendors/{driverVendorId}/driverProperties",
     * tags={"driverVendors resources"},
     * summary="获取关联于DriverVendor的DriverProperty",
     * operationId="deleteDriverPropertyByDriverVendorId",
     * produces={"driverProperty/json"},
     * @SWG\Parameter(
     * name="driverVendorId ",
     * type="integer",
     * in="path",
     * required=true
     * ),
     * @SWG\Parameter(
     * name="ids ",
     * type="string",
     * in="query",
     * required=true,
     * description="TestCase IDs, 逗号分隔"
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
     * description="输入中存在未关联到此DriverVendor的TestCase。问题唯一码[“ + exuuid + ”]",
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
    public function deleteDriverPropertyByDriverVendorId(Request $request, $driverVendorId) : string
    {
        $jsonStringResponse = $this->mapper->deleteDriverPropertyFromDriverVendor($this->mapper->parse_query($request->getQueryString()), $driverVendorId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Post(
     * path="/api/driverVendors/{driverVendorId}/driverProperties",
     * tags={"driverVendors resources"},
     * summary="添加单个或多个DriverProperty实体并链接到DriverVendor",
     * operationId="insertDriverPropertyByDriverVendorId",
     * produces={"driverProperty/json"},
     * @SWG\Parameter(
     * name="driverVendorId",
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
     * description="ID为“ + driverVendorId + ”的DriverVendor不存在。问题唯一码[“ + exuuid + ”]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Response(
     * response="403",
     * description="添加DriverProperty并连接到DriverVendor操作无法整体完成，请检查数据。并提供唯一码[“ + exuuid + ”]",
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
    public function insertDriverPropertyByDriverVendorId(Request $request, $driverVendorId) : string
    {
        $jsonStringResponse = $this->mapper->insertDriverPropertyAndLinkToDriverVendor($request->getContent(), $driverVendorId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Put(
     * path="/api/driverVendors/{driverVendorId}/driverProperties",
     * tags={"driverVendors resources"},
     * summary="建立单个或多个DriverProperty到DriverVendor的链接",
     * operationId="replaceDriverPropertyByDriverVendorId",
     * produces={"driverProperty/json"},
     * @SWG\Parameter(
     * name="driverVendorId",
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
     * description="DriverProperty IDs, 逗号分隔"
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
     * description="关联DriverProperty到DriverVendor的操作无法全部完成，错误IDs“+???+”请与管理员联系。并提供唯一码[“ + exuuid + ”]",
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
    public function replaceDriverPropertyByDriverVendorId(Request $request, $driverVendorId) : string
    {
        $jsonStringResponse = $this->mapper->replaceOrInsertDriverPropertyByDriverVendor($request->getContent(), $driverVendorId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }
}
