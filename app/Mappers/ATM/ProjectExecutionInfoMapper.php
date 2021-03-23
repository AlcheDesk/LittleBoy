<?php
/**
 * User: tryndamere.wang
 * Date: 2018/12/20
 * Time: 10:39
 */
namespace App\Mappers\ATM;

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;

class ProjectExecutionInfoMapper extends ATMBaseMapper {

    //projectExecutionInfo
    public function getProjectExecutionInfo(array $options = [], $concurrentRequest = false): string{
        $options[] = 'count';
        // generate the url
        $url = $this->generateUrl("/api/projectExecutionInfo", $this->build_query($options));
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
    
    public function getProjectExecutionInfoById(array $options = [], $id, $concurrentRequest = false): string{
        $options[] = 'count';
        // generate the url
        $url = $this->generateUrl("/api/projectExecutionInfo/" . $id, $this->build_query($options));
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
    
    //projectTestCase
    public function getTestCaseExecutionInfoByProjectId(array $options = [], $id, $concurrentRequest = false): string{
        $options[] = 'count';
        // generate the url
        $url = $this->generateUrl("/api/projectExecutionInfo/" . $id . "/testCaseExecutionInfo/", $this->build_query($options));
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
