<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:44
 */
namespace App\Services\ATM;

use App\Mappers\ATM\TagMapper;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TagService implements Service
{

    private $mapper;

    public function __construct()
    {
        $this->mapper = new TagMapper();
    }

    /**
     *
     * @SWG\Delete(
     * path="/api/tags",
     * tags={"tags resources"},
     * summary="根据条件删除多个tag",
     * operationId="deleteByCondition",
     * produces={"tag/json"},
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
     * path="/api/tags/{id}",
     * tags={"tags resources"},
     * summary="删除单个tag",
     * operationId="deleteById",
     * produces={"tag/json"},
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
     * path="/api/tags",
     * tags={"tags resources"},
     * summary="添加tag",
     * operationId="insert",
     * produces={"tag/json"},
     * @SWG\Parameter(
     * name="body",
     * in="body",
     * @SWG\Schema(
     * type="array",
     * @SWG\Items(
     * ref="#/definitions/tag"
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
     * path="/api/tags",
     * tags={"tags resources"},
     * summary="读取tags",
     * operationId="selectByCondition",
     * produces={"tag/json"},
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
     * path="/api/tags/{id}",
     * tags={"tags resources"},
     * summary="读取单个tag",
     * operationId="selectById",
     * produces={"tag/json"},
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
     * path="/api/tags",
     * tags={"tags resources"},
     * summary="更新tag",
     * operationId="update",
     * produces={"tag/json"},
     * @SWG\Parameter(
     * name="body",
     * in="body",
     * @SWG\Schema(
     * type="array",
     * @SWG\Items(
     * ref="#/definitions/tag"
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
     * path="/api/tags",
     * tags={"tags resources"},
     * summary="替换或添加tag,要求id为已存在的tagId",
     * operationId="replace",
     * produces={"tag/json"},
     * @SWG\Parameter(
     * name="body",
     * in="body",
     * @SWG\Schema(
     * type="array",
     * @SWG\Items(
     * ref="#/definitions/tag"
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
     * path="/api/tags/{tagId}/testCases",
     * tags={"tags resources"},
     * summary="根据tagId获取testCases",
     * operationId="getTestCaseByTagId",
     * produces={"tag/json"},
     * @SWG\Parameter(
     * name="tagId",
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
    public function getTestCaseByTagId(Request $request, $tagId) : string
    {
        $jsonStringResponse = $this->mapper->getTestCaseByTagId($this->mapper->parse_query($request->getQueryString()), $tagId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Post(
     * path="/api/tags/{tagId}/testCases",
     * tags={"tags resources"},
     * summary="根据tagId添加testCases",
     * operationId="postTestCaseByTagId",
     * produces={"tag/json"},
     * @SWG\Parameter(
     * name="tagId",
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
     * ref="#/definitions/tag"
     * )
     * )
     * ),
     * @SWG\Response(
     * response="200",
     * description="请求成功"
     * )
     * )
     */
    public function insertTestCaseByTagId(Request $request, $tagId) : string
    {
        $jsonStringResponse = $this->mapper->insertTestCaseAndLinkToTag($request->getContent(), $tagId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Put(
     * path="/api/tags/{tagId}/testCases",
     * tags={"tags resources"},
     * summary="替换或添加testCases",
     * operationId="replaceTestCaseByTagId",
     * produces={"tag/json"},
     * @SWG\Parameter(
     * name="tagId",
     * in="path",
     * type="integer",
     * required=true
     * ),
     * @SWG\Parameter(
     * name="body",
     * in="body",
     * @SWG\Schema(
     * type="array",
     * @SWG\Items(
     * ref="#/definitions/tag"
     * )
     * )
     * ),
     * @SWG\Response(
     * response="200",
     * description="请求成功"
     * )
     * )
     */
    public function replaceTestCaseByTagId(Request $request, $tagId) : string
    {
        $jsonStringResponse = $this->mapper->replaceOrInsertTestCaseByTag($request->getContent(), $tagId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Delete(
     * path="/api/tags/{tagId}/testCases",
     * tags={"tags resources"},
     * summary="根据条件删除testCases",
     * operationId="deleteTestCaseByTagId",
     * produces={"tag/json"},
     * @SWG\Parameter(
     * name="tagId",
     * type="integer",
     * in="path",
     * required=true,
     * ),
     * @SWG\Parameter(
     * name="ids",
     * type="integer",
     * in="query",
     * required=true,
     * ),
     * @SWG\Response(
     * response="200",
     * description="请求成功"
     * )
     * )
     */
    public function deleteTestCaseByTagId(Request $request, $tagId) : string
    {
        $jsonStringResponse = $this->mapper->deleteTestCaseFromTag($this->mapper->parse_query($request->getQueryString()), $tagId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    /**
     *
     * @SWG\Patch(
     * path="/api/tags/{tagId}/testCases",
     * tags={"tags resources"},
     * summary="更新testCases",
     * operationId="updateTestCaseByTagId",
     * produces={"tag/json"},
     * @SWG\Parameter(
     * name="tagId",
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
     * ref="#/definitions/tag"
     * )
     * )
     * ),
     * @SWG\Response(
     * response="200",
     * description="请求成功"
     * )
     * )
     */
    public function updateTestCaseByTagId(Request $request, $tagId) : string
    {
        $jsonStringResponse = $this->mapper->updateTestCaseFromTag($request->getContent(), $tagId);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }
}
