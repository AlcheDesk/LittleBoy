<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/23
 * Time: 18:44
 */
namespace App\Services\ATM;

use App\Mappers\ATM\TestCaseTypeMapper;
use App\Services\Utils\RedisUtils\ATM\TestCaseRedisUtilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

//implements Service
class TestCaseTypeService
{
    private $mapper;
    private $testCaseRedisUtilService;

    public function __construct()
    {
        $this->mapper = new TestCaseTypeMapper();
        //TODO
        $this->testCaseRedisUtilService = new TestCaseRedisUtilService();
    }

    public function selectByCondition(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->selectByCondition($this->mapper->parse_query($request->getQueryString()));
        //TODO
        // $this->testCaseRedisUtilService->removeAllRelatedCache();

        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }
}
