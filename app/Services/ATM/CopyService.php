<?php
/**
 * Created by PhpStorm.
 * User: liu
 * Date: 2018/1/23
 * Time: 18:44
 */
namespace App\Services\ATM;

use App\Mappers\ATM\CopyMapper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\Utils\RedisUtils\ATM\ProjectRedisUtilService;
use App\Services\Utils\RedisUtils\ATM\TestCaseRedisUtilService;
use App\Services\Utils\RedisUtils\ATM\InstructionRedisUtilService;

class CopyService
{

    private $mapper;
    private $projectRedisUtilService;
    private $testCaseRedisUtilService;
    private $instructionRedisUtilService;

    public function __construct()
    {
        $this->mapper = new CopyMapper();
        $this->projectRedisUtilService = new ProjectRedisUtilService();
        $this->testCaseRedisUtilService = new TestCaseRedisUtilService();
        $this->instructionRedisUtilService = new InstructionRedisUtilService();
    }

    // 复制project
    public function copyProject(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->copyProject($request->getContent());
        $this->projectRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    // 复制testCase
    public function copyTestCase(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->copyTestCase($request->getContent());
        $this->testCaseRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    // 复制instruction
    public function copyInstructionInTestCase(Request $request, $testCaseId) : string
    {
        $jsonStringResponse = $this->mapper->copyInstructionInTestCase($request->getContent(), $testCaseId);
        $this->instructionRedisUtilService->removeAllRelatedCache();
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    // 复制testCaseOverwrite
    public function copyTestCaseOverwrite(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->copyTestCaseOverwrite($request->getContent());
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }
}
