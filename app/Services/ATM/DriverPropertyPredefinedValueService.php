<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:44
 */
namespace App\Services\ATM;

use App\Mappers\ATM\DriverPropertyPredefinedValueMapper;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DriverPropertyPredefinedValueService implements Service
{

    private $mapper;

    public function __construct()
    {
        $this->mapper = new DriverPropertyPredefinedValueMapper();
    }

    /**
     *
     * @SWG\Delete(
     * path="/api/driverPropertyPredefinedValues",
     * tags={"driverPropertyPredefinedValues resources"},
     * summary="åˆ é™¤DriverPropertyPredefinedValue",
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
     * description="é?‡åˆ°ç³»ç»Ÿå†…éƒ¨é”™è¯¯ è¯·ä¸Žç®¡ç?†å‘˜è?”ç³»ã€‚å¹¶æ??ä¾›é”™è¯¯å”¯ä¸€ç ?[â€œ+exuuid+â€?]ã€‚",
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
     * path="/api/driverPropertyPredefinedValues/{id}",
     * tags={"driverPropertyPredefinedValues resources"},
     * summary="åˆ é™¤å?•ä¸ªDriverPropertyPredefinedValue",
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
     * description="é?‡åˆ°ç³»ç»Ÿå†…éƒ¨é”™è¯¯ è¯·ä¸Žç®¡ç?†å‘˜è?”ç³»ã€‚å¹¶æ??ä¾›é”™è¯¯å”¯ä¸€ç ?[â€œ+exuuid+â€?]ã€‚",
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
     * path="/api/driverPropertyPredefinedValues",
     * tags={"driverPropertyPredefinedValues resources"},
     * summary="æ·»åŠ driverPropertyPredefinedValue",
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
     * description="æ·»åŠ æ“?ä½œæ— æ³•å®Œæˆ?ï¼Œè¯·ä¸Žç®¡ç?†å‘˜è?”ç³»ã€‚å¹¶æ??ä¾›å”¯ä¸€ç ?[â€œ+exuuid+â€?]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Response(
     * response="500",
     * description="é?‡åˆ°ç³»ç»Ÿå†…éƒ¨é”™è¯¯ è¯·ä¸Žç®¡ç?†å‘˜è?”ç³»ã€‚å¹¶æ??ä¾›é”™è¯¯å”¯ä¸€ç ?[â€œ+exuuid+â€?]ã€‚"
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
     * path="/api/driverPropertyPredefinedValues",
     * tags={"driverPropertyPredefinedValues resources"},
     * summary="è¯»å?–driverPropertyPredefinedValue",
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
     * description="é?‡åˆ°ç³»ç»Ÿå†…éƒ¨é”™è¯¯ è¯·ä¸Žç®¡ç?†å‘˜è?”ç³»ã€‚å¹¶æ??ä¾›é”™è¯¯å”¯ä¸€ç ?[â€œ+exuuid+â€?]ã€‚",
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
     * path="/api/driverPropertyPredefinedValues/{id}",
     * tags={"driverPropertyPredefinedValues resources"},
     * summary="è¯»å?–å?•ä¸ªDriverPropertyPredefinedValue",
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
     * description="é?‡åˆ°ç³»ç»Ÿå†…éƒ¨é”™è¯¯ è¯·ä¸Žç®¡ç?†å‘˜è?”ç³»ã€‚å¹¶æ??ä¾›é”™è¯¯å”¯ä¸€ç ?[â€œ+exuuid+â€?]ã€‚",
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
     * path="/api/driverPropertyPredefinedValues",
     * tags={"driverPropertyPredefinedValues resources"},
     * summary="æ›´æ–°å?•ä¸ªDriverPropertyPredefinedValue",
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
     * description="æ·»åŠ æ“?ä½œæ— æ³•å®Œæˆ?ï¼Œè¯·ä¸Žç®¡ç?†å‘˜è?”ç³»ã€‚å¹¶æ??ä¾›å”¯ä¸€ç ?[â€œ+exuuid+â€?]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Response(
     * response="403",
     * description="æ·»åŠ æ“?ä½œæ— æ³•å®Œæˆ?ï¼Œè¯·ä¸Žç®¡ç?†å‘˜è?”ç³»ã€‚å¹¶æ??ä¾›å”¯ä¸€ç ?[â€œ+exuuid+â€?]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Response(
     * response="500",
     * description="é?‡åˆ°ç³»ç»Ÿå†…éƒ¨é”™è¯¯ è¯·ä¸Žç®¡ç?†å‘˜è?”ç³»ã€‚å¹¶æ??ä¾›é”™è¯¯å”¯ä¸€ç ?[â€œ+exuuid+â€?]ã€‚"
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
     * path="/api/driverPropertyPredefinedValues",
     * tags={"driverPropertyPredefinedValues resources"},
     * summary="æ›¿æ?¢æˆ–æ·»åŠ DriverPropertyPredefinedValue",
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
     * description="æ·»åŠ æ“?ä½œæ— æ³•å®Œæˆ?ï¼Œè¯·ä¸Žç®¡ç?†å‘˜è?”ç³»ã€‚å¹¶æ??ä¾›å”¯ä¸€ç ?[â€œ+exuuid+â€?]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Response(
     * response="403",
     * description="æ·»åŠ æ“?ä½œæ— æ³•å®Œæˆ?ï¼Œè¯·ä¸Žç®¡ç?†å‘˜è?”ç³»ã€‚å¹¶æ??ä¾›å”¯ä¸€ç ?[â€œ+exuuid+â€?]",
     * @SWG\Schema(
     * ref="#/definitions/ErrorModel"
     * )
     * ),
     * @SWG\Response(
     * response="500",
     * description="é?‡åˆ°ç³»ç»Ÿå†…éƒ¨é”™è¯¯ è¯·ä¸Žç®¡ç?†å‘˜è?”ç³»ã€‚å¹¶æ??ä¾›é”™è¯¯å”¯ä¸€ç ?[â€œ+exuuid+â€?]ã€‚"
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
 * path="/api/driverPropertyPredefinedValues/{driverPropertyPredefinedValueId}/drivers",
 * tags={"driverPropertyPredefinedValues resources"},
 * summary="èŽ·å?–å…³è?”äºŽDriverPropertyPredefinedValueçš„Driver",
 * operationId="getDriversByDriverPropertyPredefinedValueId",
 * produces={"application/json"},
 * @SWG\Parameter(
 * name="driverPropertyPredefinedValueId",
 * type="integer",
 * in="path",
 * required=true
 * ),
 * @SWG\Parameter(
 * name="name",
 * type="string",
 * in="query",
 * required=false,
 * description="Driver å??å­—"
 * ),
 * @SWG\Parameter(
 * name="type",
 * type="string",
 * in="query",
 * required=false,
 * description="Driver ç±»åž‹"
 * ),
 * @SWG\Parameter(
 * name="startDate",
 * type="integer",
 * in="query",
 * required=false,
 * description="Driver åˆ›å»ºèµ·å§‹æ—¶é—´ [unix second]"
 * ),
 * @SWG\Parameter(
 * name="endDate",
 * type="integer",
 * in="query",
 * required=false,
 * description="Driver åˆ›å»ºç»ˆç»“æ—¶é—´ [unix second]"
 * ),
 * @SWG\Response(
 * response="200",
 * description="NO MESSAGE"
 * ),
 * @SWG\Response(
 * response="500",
 * description="é?‡åˆ°ç³»ç»Ÿå†…éƒ¨é”™è¯¯ è¯·ä¸Žç®¡ç?†å‘˜è?”ç³»ã€‚å¹¶æ??ä¾›é”™è¯¯å”¯ä¸€ç ?[â€œ+exuuid+â€?]ã€‚",
 * @SWG\Schema(
 * ref="#/definitions/ErrorModel"
 * )
 * )
 * )
 */
}
