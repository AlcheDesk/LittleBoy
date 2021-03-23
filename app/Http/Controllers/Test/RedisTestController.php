<?php
/**
 * Created by PhpStorm.
 * User: liu
 * Date: 2018/4/16
 * Time: 16:19
 */
namespace App\Http\Controllers\Test;

use App\Services\ATM\InstructionResultService;
use App\Services\ATM\TestCaseService;
use Illuminate\Http\Request;
use Redis;

class RedisTestController
{

    private $baseService;

    public function __construct()
    {
        $this->testCaseMapper = new TestCaseService();
        $this->instructionResultMapper = new InstructionResultService();
    }

    public function redisTest(Request $request)
    {
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
        $redis->set('test', 'hello redis');
        echo $redis->get('test');
    }
}