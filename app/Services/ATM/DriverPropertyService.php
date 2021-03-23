<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:44
 */
namespace App\Services\ATM;

use App\Mappers\ATM\DriverPropertyMapper;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DriverPropertyService implements Service {

	private $mapper;

	public function __construct() {
		$this->mapper = new DriverPropertyMapper();
	}

	/**
	 *
	 * @SWG\Delete(
	 * path="/api/driverPropertys",
	 * tags={"driverPropertys resources"},
	 * summary="删除DriverProperty",
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
	public function deleteByCondition(Request $request) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->deleteByOptions($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	/**
	 *
	 * @SWG\Delete(
	 * path="/api/driverPropertys/{id}",
	 * tags={"driverPropertys resources"},
	 * summary="删除单个DriverProperty",
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
	public function deleteById(Request $request, $id) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->deleteById($id);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	/**
	 *
	 * @SWG\Post(
	 * path="/api/driverPropertys",
	 * tags={"driverPropertys resources"},
	 * summary="添加DriverProperty",
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
	public function insert(Request $request) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->insert($request->getContent());
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	/**
	 *
	 * @SWG\Get(
	 * path="/api/driverPropertys",
	 * tags={"driverPropertys resources"},
	 * summary="读取DriverProperty",
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
	public function selectByCondition(Request $request) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->selectByOptions($this->mapper->parse_query($request->getQueryString()));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	/**
	 *
	 * @SWG\Get(
	 * path="/api/driverPropertys/{id}",
	 * tags={"driverPropertys resources"},
	 * summary="读取单个DriverProperty",
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
	public function selectById(Request $request, $id) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->selectById($this->mapper->parse_query($request->getQueryString()), $id);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	/**
	 *
	 * @SWG\Patch(
	 * path="/api/driverPropertys",
	 * tags={"driverPropertys resources"},
	 * summary="更新单个DriverProperty",
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
	public function update(Request $request) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->update($request->getContent());
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	/**
	 *
	 * @SWG\Put(
	 * path="/api/driverPropertys",
	 * tags={"driverPropertys resources"},
	 * summary="替换或添加DriverProperty",
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
	public function replace(Request $request) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->replace($request->getContent());
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	/**
	 *
	 * @SWG\Get(
	 * path="/api/driverPropertys/{driverPropertyId}/drivers",
	 * tags={"elements resources"},
	 * summary="读取关联于DriverProperty的Driver",
	 * operationId="getDriverByDriverPropertyId",
	 * produces={"application/json"},
	 * @SWG\Parameter(
	 * name="driverPropertyId ",
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
	 * @SWG\Parameter(
	 * name="priority",
	 * type="integer",
	 * in="query",
	 * required=false,
	 * description="Priority，优先级"
	 * ),
	 * @SWG\Parameter(
	 * name="type",
	 * type="string",
	 * in="query",
	 * required=false,
	 * description="Type，类型"
	 * ),
	 * @SWG\Parameter(
	 * name="status",
	 * type="string",
	 * in="query",
	 * required=false,
	 * description="Status，状态"
	 * ),
	 * @SWG\Parameter(
	 * name="startDate",
	 * type="integer",
	 * in="query",
	 * required=false,
	 * description="创建启示时间[unix second]"
	 * ),
	 * @SWG\Parameter(
	 * name="endDate",
	 * type="integer",
	 * in="query",
	 * required=false,
	 * description="创建结束时间 [unix second]"
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
	public function getDriverByDriverPropertyId(Request $request, $driverPropertyId) : string {
		$jsonStringResponse = $this->mapper->getDriverByDriverPropertyId($this->mapper->parse_query($request->getQueryString()), $driverPropertyId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	// driverPropertyPredefinedValues by driverProperty
	public function getDriverPropertyPredefinedValueByDriverPropertyId(Request $request, $driverPropertyId) : string {
		$jsonStringResponse = $this->mapper->getDriverPropertyPredefinedValueByDriverPropertyId($this->mapper->parse_query($request->getQueryString()), $driverPropertyId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function deleteDriverPropertyPredefinedValueByDriverPropertyId(Request $request, $driverPropertyId) : string {
		$jsonStringResponse = $this->mapper->deleteDriverPropertyPredefinedValueFromDriverProperty($this->mapper->parse_query($request->getQueryString()), $driverPropertyId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function insertDriverPropertyPredefinedValueByDriverPropertyId(Request $request, $driverPropertyId) : string {
		$jsonStringResponse = $this->mapper->insertDriverPropertyPredefinedValueAndLinkToDriverProperty($request->getContent(), $driverPropertyId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function updateDriverPropertyPredefinedValueByDriverPropertyId(Request $request, $driverPropertyId) : string {
		$jsonStringResponse = $this->mapper->updateDriverPropertyPredefinedValueFromDriverProperty($request->getContent(), $driverPropertyId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	public function replaceDriverPropertyPredefinedValueByDriverPropertyId(Request $request, $driverPropertyId) : string {
		$jsonStringResponse = $this->mapper->replaceOrInsertDriverPropertyPredefinedValueByDriverProperty($request->getContent(), $driverPropertyId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}
}
