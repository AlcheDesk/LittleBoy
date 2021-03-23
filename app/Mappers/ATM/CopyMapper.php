<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/30
 * Time: 12:02
 */
namespace App\Mappers\ATM;

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;

class CopyMapper extends ATMBaseMapper
{

    public function copyProject(string $jsonStringBody, $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/copy/projects");

        if ($concurrentRequest) {
            return new Request('POST', $url, $this->headers, $jsonStringBody);
        }
        // sent to the data source server
        $response = $this->client()->post($url, [
            'body' => $jsonStringBody
        ]);
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

    public function copyTestCase(string $jsonStringBody, $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/copy/testCases");

        if ($concurrentRequest) {
            return new Request('POST', $url, $this->headers, $jsonStringBody);
        }
        // sent to the data source server
        $response = $this->client()->post($url, [
            'body' => $jsonStringBody
        ]);
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

    public function copyInstructionInTestCase(string $jsonStringBody, $testCaseId, $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/copy/testCases/" . $testCaseId . "/instructions");

        if ($concurrentRequest) {
            return new Request('POST', $url, $this->headers, $jsonStringBody);
        }
        // sent to the data source server
        $response = $this->client()->post($url, [
            'body' => $jsonStringBody
        ]);
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

    public function copyTestCaseOverwrite(string $jsonStringBody, $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/copy/testCaseOverwrites");

        if ($concurrentRequest) {
            return new Request('POST', $url, $this->headers, $jsonStringBody);
        }
        // sent to the data source server
        $response = $this->client()->post($url, [
            'body' => $jsonStringBody
        ]);
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
