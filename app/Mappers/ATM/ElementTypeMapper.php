<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/30
 * Time: 12:02
 */
namespace App\Mappers\ATM;

use App\Mappers\BaseMapper;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;

class ElementTypeMapper extends ATMBaseMapper implements BaseMapper
{

    public function countByOptions(array $options = [], $concurrentRequest = false): string
    {
        $options[] = 'count';
        // generate the url
        $url = $this->generateUrl("/api/elementTypes", $this->build_query($options));
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

    public function deleteByOptions(array $options = [], $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/elementTypes", $this->build_query($options));
        if ($concurrentRequest) {
            return new Request('DELETE', $url);
        }
        // sent to the data source server
        $response = $this->client()->delete($url);
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

    public function deleteById($id, $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/elementTypes/" . $id);
        if ($concurrentRequest) {
            return new Request('DELETE', $url);
        }
        // sent to the data source server
        $response = $this->client()->delete($url);
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

    public function insert(string $jsonStringBody, $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/elementTypes");

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

    public function selectByOptions(array $options = [], $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/elementTypes/", $this->build_query($options));
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

    public function selectById(array $options = [], $id, $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/elementTypes/" . $id, $this->build_query($options));
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

    public function update(string $jsonStringBody, $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/elementTypes");

        if ($concurrentRequest) {
            return new Request('PATCH', $url, $this->headers, $jsonStringBody);
        }
        // sent to the data source server
        $response = $this->client()->patch($url, [
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

    public function replace(string $jsonStringBody, $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/elementTypes");

        if ($concurrentRequest) {
            return new Request('PUT', $url, $this->headers, $jsonStringBody);
        }
        // sent to the data source server
        $response = $this->client()->put($url, [
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

    // =====elementType elementAction link start =====
    public function deleteInstructionActionByElementTypeId(array $options = [], $elementTypeId, $concurrentRequest = false): string
    {
        // generate the link url
        $url = $this->generateUrl("/api/elementTypes/" . $elementTypeId . "/instructionActions", $this->build_query($options));
        if ($concurrentRequest) {
            return new Request('DELETE', $url);
        }
        // sent to the data source server
        $response = $this->client()->delete($url);
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

    public function insertInstructionActionByElementTypeId(string $jsonStringBody, $elementTypeId, $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/elementTypes/" . $elementTypeId . "/instructionActions");

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

    public function getInstructionActionByElementTypeId(array $options = [], $elementTypeId, $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/elementTypes/" . $elementTypeId . "/instructionActions", $this->build_query($options));
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

    public function updateInstructionActionByElementTypeId(string $jsonStringBody, $elementTypeId, $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/elementTypes/" . $elementTypeId . "/instructionActions");

        if ($concurrentRequest) {
            return new Request('PATCH', $url, $this->headers, $jsonStringBody);
        }
        // sent to the data source server
        $response = $this->client()->patch($url, [
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

    public function replaceInstructionActionByElementTypeId(string $jsonStringBody, $elementTypeId, $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/instructionActions");

        if ($concurrentRequest) {
            return new Request('PUT', $url, $this->headers, $jsonStringBody);
        }
        // sent to the data source server
        $response = $this->client()->put($url, [
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

    // =====elementType elementAction link end =====

    // =====elementType elementLocatorType link start =====
    public function deleteElementLocatorTypeFromElementType(array $options = [], $elementTypeId, $concurrentRequest = false): string
    {
        // generate the link url
        $url = $this->generateUrl("/api/elementTypes/" . $elementTypeId . "/elementLocatorTypes", $this->build_query($options));
        if ($concurrentRequest) {
            return new Request('DELETE', $url);
        }
        // sent to the data source server
        $response = $this->client()->delete($url);
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

    public function insertElementLocatorTypeAndLinkToElementType(string $jsonStringBody, $elementTypeId, $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/elementTypes/" . $elementTypeId . "/elementLocatorTypes");

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

    public function getElementLocatorTypeByElementTypeId(array $options = [], $elementTypeId, $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/elementTypes/" . $elementTypeId . "/elementLocatorTypes", $this->build_query($options));
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

    public function updateElementLocatorTypeFromElementType(string $jsonStringBody, $elementTypeId, $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/elementTypes/" . $elementTypeId . "/elementLocatorTypes");

        if ($concurrentRequest) {
            return new Request('PATCH', $url, $this->headers, $jsonStringBody);
        }
        // sent to the data source server
        $response = $this->client()->patch($url, [
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

    public function replaceOrInsertElementLocatorTypeByElementType(string $jsonStringBody, $elementTypeId, $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/elementLocatorTypes");

        if ($concurrentRequest) {
            return new Request('PUT', $url, $this->headers, $jsonStringBody);
        }
        // sent to the data source server
        $response = $this->client()->put($url, [
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

    // =====elementType elementLocatorType link end =====

    // =====elementType instructionOption link start =====
    public function deleteInstructionOptionFromElementType(array $options = [], $elementTypeId, $concurrentRequest = false): string
    {
        // generate the link url
        $url = $this->generateUrl("/api/elementTypes/" . $elementTypeId . "/instructionOptions", $this->build_query($options));
        if ($concurrentRequest) {
            return new Request('DELETE', $url);
        }
        // sent to the data source server
        $response = $this->client()->delete($url);
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

    public function insertInstructionOptionAndLinkToElementType(string $jsonStringBody, $elementTypeId, $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/elementTypes/" . $elementTypeId . "/instructionOptions");

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

    public function getInstructionOptionByElementTypeId(array $options = [], $elementTypeId, $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/elementTypes/" . $elementTypeId . "/instructionOptions", $this->build_query($options));
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

    public function replaceOrInsertInstructionOptionByElementType(string $jsonStringBody, $elementTypeId, $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/elementTypes/" . $elementTypeId . "/instructionOptions");

        if ($concurrentRequest) {
            return new Request('PUT', $url, $this->headers, $jsonStringBody);
        }
        // sent to the data source server
        $response = $this->client()->put($url, [
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
    // =====elementType instructionOption link end =====
}
