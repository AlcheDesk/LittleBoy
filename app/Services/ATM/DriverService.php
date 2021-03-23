<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:44
 */
namespace App\Services\ATM;

use App\Mappers\ATM\DriverMapper;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DriverService implements Service {

	private $mapper;

	public function __construct() {
		$this->mapper = new DriverMapper();
	}

	/**
	 *
	 * @SWG\Delete(
	 * path="/api/drivers",
	 * tags={"drivers resources"},
	 * summary="根据条件删除driver",
	 * operationId="deleteByCondition",
	 * produces={"application/json"},
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
	 * name="status",
	 * type="string",
	 * in="query",
	 * ),
	 * @SWG\Parameter(
	 * name="startDate",
	 * type="string",
	 * in="query",
	 * ),
	 * @SWG\Parameter(
	 * name="endDate",
	 * type="string",
	 * in="query",
	 * ),
	 * @SWG\Parameter(
	 * name="orderBy",
	 * type="string",
	 * in="query",
	 * ),
	 * @SWG\Response(
	 * response="200",
	 * description="请求成功"
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
	 * path="/api/drivers/{id}",
	 * tags={"drivers resources"},
	 * summary="根据id删除driver",
	 * operationId="deleteById",
	 * produces={"application/json"},
	 * @SWG\Parameter(
	 * name="id",
	 * type="integer",
	 * in="path",
	 * ),
	 * @SWG\Response(
	 * response="200",
	 * description="请求成功"
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
	 * path="/api/drivers",
	 * tags={"drivers resources"},
	 * summary="添加drivers",
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
	public function insert(Request $request) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->insert($request->getContent());
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	/**
	 *
	 * @SWG\Get(
	 * path="/api/drivers/",
	 * tags={"drivers resources"},
	 * summary="获取drivers",
	 * operationId="selectByCondition",
	 * produces={"application/json"},
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
	 * name="status",
	 * type="string",
	 * in="query",
	 * ),
	 * @SWG\Parameter(
	 * name="startDate",
	 * type="string",
	 * in="query",
	 * ),
	 * @SWG\Parameter(
	 * name="endDate",
	 * type="string",
	 * in="query",
	 * ),
	 * @SWG\Parameter(
	 * name="orderBy",
	 * type="string",
	 * in="query",
	 * ),
	 * @SWG\Response(
	 * response="200",
	 * description="请求成功"
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
	 * path="/api/drivers/{id}",
	 * tags={"drivers resources"},
	 * summary="根据ID获取driver",
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
	public function selectById(Request $request, $id) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->selectById($this->mapper->parse_query($request->getQueryString()), $id);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	/**
	 *
	 * @SWG\Patch(
	 * path="/api/drivers",
	 * tags={"drivers resources"},
	 * summary="更新drivers",
	 * operationId="update",
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
	public function update(Request $request) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->update($request->getContent());
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	/**
	 *
	 * @SWG\Put(
	 * path="/api/drivers",
	 * tags={"drivers resources"},
	 * summary="替换 drivers",
	 * operationId="replace",
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
	public function replace(Request $request) : string {
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->mapper->replace($request->getContent());
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	// 关联接口

	/**
	 *
	 * @SWG\Get(
	 * path="/api/drivers/{driverId}/driverProperties",
	 * tags={"drivers resources"},
	 * summary="根据driverId获取driverProperties",
	 * operationId="getDriverPropertieByDriverId",
	 * produces={"application/json"},
	 * @SWG\Parameter(
	 * name="driverId",
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
	public function getDriverPropertyByDriverId(Request $request, $driverId) : string {
		$jsonStringResponse = $this->mapper->getDriverPropertyByDriverId($this->mapper->parse_query($request->getQueryString()), $driverId);
		Log::info('Service layer bbb ' . var_export($jsonStringResponse, true));
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	/**
	 *
	 * @SWG\Post(
	 * path="/api/drivers/{driverId}/driverProperties",
	 * tags={"drivers resources"},
	 * summary="添加driverProperties到指定driver",
	 * operationId="insertDriverPropertieByDriverId",
	 * produces={"application/json"},
	 * @SWG\Parameter(
	 * name="driverId",
	 * type="integer",
	 * in="path",
	 * ),
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
	public function insertDriverPropertyByDriverId(Request $request, $driverId) : string {
		$jsonStringResponse = $this->mapper->insertDriverPropertyAndLinkToDriver($request->getContent(), $driverId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	/**
	 *
	 * @SWG\Put(
	 * path="/api/drivers/{driverId}/driverProperties",
	 * tags={"drivers resources"},
	 * summary="添加或者替换DriverProperties",
	 * operationId="replaceDriverPropertieByDriverId",
	 * produces={"application/json"},
	 * @SWG\Parameter(
	 * name="driverId",
	 * type="integer",
	 * in="path",
	 * required=true,
	 * ),
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
	public function replaceDriverPropertyByDriverId(Request $request, $driverId) : string {
		$jsonStringResponse = $this->mapper->replaceOrInsertDriverPropertyByDriverId($request->getContent(), $driverId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	/**
	 *
	 * @SWG\Delete(
	 * path="/api/drivers/{driverId}/driverProperties",
	 * tags={"drivers resources"},
	 * summary="删除指定driverId关联的driverProperties",
	 * operationId="deleteDriverPropertieByDriverId",
	 * produces={"application/json"},
	 * @SWG\Parameter(
	 * name="driverId",
	 * type="integer",
	 * in="path",
	 * ),
	 * @SWG\Response(
	 * response="200",
	 * description="请求成功"
	 * )
	 * )
	 */
	public function deleteDriverPropertyByDriverId(Request $request, $driverId) : string {
		$jsonStringResponse = $this->mapper->deleteDriverPropertyFromDriver($this->mapper->parse_query($request->getQueryString()), $driverId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}

	/**
	 *
	 * @SWG\Get(
	 * path="/api/drivers/{driverId}/testCases",
	 * tags={"drivers resources"},
	 * summary="获取指定driverId的testCases",
	 * operationId="getTestCaseByDriverId",
	 * produces={"application/json"},
	 * @SWG\Parameter(
	 * name="driverId",
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
	public function getTestCaseByDriverId(Request $request, $driverId) : string {
		$jsonStringResponse = $this->mapper->getTestCaseByDriverPrimaryKey($this->mapper->parse_query($request->getQueryString()), $driverId);
		Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return $jsonStringResponse;
	}
}
