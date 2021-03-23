<?php
/**
 * Created by PhpStorm.
 * User: scott.fu
 * Date: 2018/1/30
 * Time: 12:02
 */
namespace App\Mappers\EMS;

use App\Mappers\BaseMapper;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;

class TaskTypeMapper extends EMSBaseMapper implements BaseMapper
{

    public function countByOptions(array $options = [], $concurrentRequest = false): string
    {
        $options[] = 'count';
        // generate the url
        $url = $this->generateUrl("/api/taskTypes", $this->build_query($options));
        // return as request
        if ($concurrentRequest) {
            return new Request('GET', $url);
        }
        // sent to the data source server
        $response = $this->client->get($url);
        // check the response
        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            // return the meowlomo response as array
            return $response->getBody();
        } else {
            $responseArray = json_decode($response->getBody(), true);
            Log::error('Unsuccessful response from EMS ' . get_class($this) . ' update with http status: ' . $response->getStatusCode() . ' and Error message: ' . $responseArray['error']);
            return $response->getBody(); // return $responseArray;
        }
    }

    public function deleteByOptions(array $options = [], $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/taskTypes", $this->build_query($options));
        if ($concurrentRequest) {
            return new Request('DELETE', $url);
        }
        // sent to the data source server
        $response = $this->client->delete($url);
        // check the response
        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            // return the meowlomo response as array
            return $response->getBody();
        } else {
            $responseArray = json_decode($response->getBody(), true);
            Log::error('Unsuccessful response from EMS ' . get_class($this) . ' update with http status: ' . $response->getStatusCode() . ' and Error message: ' . $responseArray['error']);
            return $response->getBody(); // return $responseArray;
        }
    }

    public function deleteById($id, $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/taskTypes/" . $id);
        if ($concurrentRequest) {
            return new Request('DELETE', $url);
        }
        // sent to the data source server
        $response = $this->client->delete($url);
        // check the response
        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            // return the meowlomo response as array
            return $response->getBody();
        } else {
            $responseArray = json_decode($response->getBody(), true);
            Log::error('Unsuccessful response from EMS ' . get_class($this) . ' update with http status: ' . $response->getStatusCode() . ' and Error message: ' . $responseArray['error']);
            return $response->getBody(); // return $responseArray;
        }
    }

    public function insert(string $jsonStringBody, $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/taskTypes");

        if ($concurrentRequest) {
            return new Request('POST', $url, $this->headers, $jsonStringBody);
        }
        // sent to the data source server
        $response = $this->client->post($url, [
            'body' => $jsonStringBody
        ]);
        // check the response
        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            // return the meowlomo response as array
            return $response->getBody();
        } else {
            $responseArray = json_decode($response->getBody(), true);
            Log::error('Unsuccessful response from EMS ' . get_class($this) . ' update with http status: ' . $response->getStatusCode() . ' and Error message: ' . $responseArray['error']);
            return $response->getBody(); // return $responseArray;
        }
    }

    public function selectByOptions(array $options = [], $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/taskTypes/", $this->build_query($options));
        // return as request
        if ($concurrentRequest) {
            return new Request('GET', $url);
        }
        // sent to the data source server
        $response = $this->client->get($url);
        // check the response
        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            // return the meowlomo response as array
            return $response->getBody();
        } else {
            $responseArray = json_decode($response->getBody(), true);
            Log::error('Unsuccessful response from EMS ' . get_class($this) . ' update with http status: ' . $response->getStatusCode() . ' and Error message: ' . $responseArray['error']);
            return $response->getBody(); // return $responseArray;
        }
    }

    public function selectById(array $options = [], $id, $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/taskTypes/" . $id, $this->build_query($options));
        // return as request
        if ($concurrentRequest) {
            return new Request('GET', $url);
        }
        // sent to the data source server
        $response = $this->client->get($url);
        // check the response
        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            // return the meowlomo response as array
            return $response->getBody();
        } else {
            $responseArray = json_decode($response->getBody(), true);
            Log::error('Unsuccessful response from EMS ' . get_class($this) . ' update with http status: ' . $response->getStatusCode() . ' and Error message: ' . $responseArray['error']);
            return $response->getBody(); // return $responseArray;
        }
    }

    public function update(string $jsonStringBody, $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/taskTypes");

        if ($concurrentRequest) {
            return new Request('PATCH', $url, $this->headers, $jsonStringBody);
        }
        // sent to the data source server
        $response = $this->client->patch($url, [
            'body' => $jsonStringBody
        ]);
        // check the response
        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            // return the meowlomo response as array
            return $response->getBody();
        } else {
            $responseArray = json_decode($response->getBody(), true);
            Log::error('Unsuccessful response from EMS ' . get_class($this) . ' update with http status: ' . $response->getStatusCode() . ' and Error message: ' . $responseArray['error']);
            return $response->getBody(); // return $responseArray;
        }
    }

    public function replace(string $jsonStringBody, $concurrentRequest = false): string
    {
        // generate the url
        $url = $this->generateUrl("/api/taskTypes");

        if ($concurrentRequest) {
            return new Request('PUT', $url, $this->headers, $jsonStringBody);
        }
        // sent to the data source server
        $response = $this->client->put($url, [
            'body' => $jsonStringBody
        ]);
        // check the response
        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            // return the meowlomo response as array
            return $response->getBody();
        } else {
            $responseArray = json_decode($response->getBody(), true);
            Log::error('Unsuccessful response from EMS ' . get_class($this) . ' update with http status: ' . $response->getStatusCode() . ' and Error message: ' . $responseArray['error']);
            return $response->getBody(); // return $responseArray;
        }
    }
}
