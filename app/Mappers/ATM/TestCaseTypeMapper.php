<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/30
 * Time: 12:02
 */
namespace App\Mappers\ATM;

// use App\Mappers\BaseMapper;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;

//implements BaseMapper
class TestCaseTypeMapper extends ATMBaseMapper
{
    //readTestCaseTypes
    public function selectByCondition(array $options = [], $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/testCaseTypes/", $this->build_query($options));
        // return as request
        if ($concurrentRequest) {
            return new Request('GET', $url);
        }
        // sent to the data source server
        $response = $this->client()->get($url);
        // check the response
        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            // return the meowlomo response as array
            return $response->getBody();
        } else {
            $responseArray = json_decode($response->getBody(), true);
            Log::error('Unsuccessful response from ATM ' . __CLASS__ . ' ' . __FUNCTION__ . ' with http status: ' . $response->getStatusCode() . ' and Error message: ' . $responseArray['error']);
            return $response->getBody(); // return $responseArray;
        }
    }
}
