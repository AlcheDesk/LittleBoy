<?php
/**
 * Created by PhpStorm.
 * User: liu
 * Date: 2018/4/16
 * Time: 16:19
 */
namespace App\Http\Controllers\Test;

use App\Mappers\ATM\ATMBaseMapper;
use App\Services\ATM\InstructionResultService;
use App\Services\ATM\TestCaseService;
use Illuminate\Http\Request;

class ApiTestController extends ATMBaseMapper
{

    private $baseService;

    public function __construct()
    {
        $this->testCaseMapper = new TestCaseService();
        $this->instructionResultMapper = new InstructionResultService();
    }

    public function apiTest(Request $request)
    {
        // generate the url
        $url = $this->testCaseMapper->generateUrl($request['url'], null);
        $json = $request['data'];
        // sent to the data source server
        if ($request['method'] == "GET") {
            $response = $this->testCaseMapper->client->get($url);
        } else if ($request['method'] == "POST") {
            $body = json_encode($json, JSON_UNESCAPED_UNICODE);
            $response = $this->testCaseMapper->client->post($url, [
                'body' => $body
            ]);
        }
        // check the response
        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            // return the meowlomo response as array
            return json_decode($response->getBody(), true);
        } else {
            return null;
        }
    }
}