<?php
namespace App\Services\ATM;

use App\Mappers\ATM\DriverMapper;
use App\Services\Utils\JsonPathUtilService;
use function GuzzleHttp\json_encode;
use function GuzzleHttp\Psr7\build_query;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Predis;
use SoapClient;

class PreExecutionService
{

    private $currentRedis;

    private $jsonUtilService;

    public function __construct()
    {
        $this->jsonUtilService = new JsonPathUtilService();
    }

    public function processHttpPreExecution(Request $request): string
    {
        // get the fields for the http execution
        $jsonObjContent = json_decode($request->getContent());
        $dataJsonArray = array();
        // loop the json array
        if (! is_array($jsonObjContent)) {
            $jsonRequest = json_decode($request->getContent(), true);
            array_push($dataJsonArray, $this->processHttpPreExecutionJsonRequest($request, $jsonRequest));
        } else {
            $jsonObjContent = json_decode($request->getContent(), true);
            foreach ($jsonObjContent as $jsonRequest) {
                array_push($dataJsonArray, $this->processHttpPreExecutionJsonRequest($request, $jsonRequest));
            }
        }
        $responseArray = [
            'metadate' => null,
            'data' => $dataJsonArray,
            'error' => null
        ];
        return json_encode($responseArray, JSON_UNESCAPED_UNICODE);
    }

    private function processHttpPreExecutionJsonRequest(Request $request, array $jsonRequest): array
    {
        $method = $jsonRequest['method'];
        $url = $jsonRequest['url'];
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            $error = ValidationException::withMessages([
                'url' => [
                    'The url is no valid'
                ]
            ]);
            throw $error;
        }
        $requestHeaders = $jsonRequest['requestHeaders'];
        $queryParameters = $jsonRequest['queryParameters'];
        $jsonPath = '';
        if (array_key_exists('jsonPath', $jsonRequest)) {
            $jsonPath = $jsonRequest['jsonPath'];
        }

        if (array_key_exists('jsonPath', $jsonRequest)) {
            $jsonPath = $jsonRequest['jsonPath'];
        }
        if (array_key_exists("Cookie", $requestHeaders)) {
            $finalArray = array();
            $asArr = explode('; ', $requestHeaders['Cookie']);
            foreach ($asArr as $val) {
                $tmp = explode('=', $val);
                $finalArray[$tmp[0]] = $tmp[1];
            }
            Log::info('aaa');
            Log::info($finalArray);
            Log::info('bbb');
            $parse = parse_url($this->generateUrl($url, $this->build_query($queryParameters)));
            $cookieJar = \GuzzleHttp\Cookie\CookieJar::fromArray($finalArray, $parse['host']);
            $client = new Client([
                'headers' => $requestHeaders,
                'cookies' => $cookieJar
            ]);
        } else {
            $client = new Client([
                'headers' => $requestHeaders
            ]);
        }

        try {
            $response = $client->request($method, $this->generateUrl($url, $this->build_query($queryParameters)));
            $responseBody = (string) $response->getBody();
            error_log($responseBody);
            // chekc if we need to return by the processing the jsonpath
            if (! isset($jsonPath) || trim($jsonPath) === '') {
                $processedReturnArray = $this->constructionHttpPreExecutionResponseData($request, $response, $responseBody);
                return $processedReturnArray;
            } else {
                // get the json path value
                $processedReturnArray = $this->constructionHttpPreExecutionResponseData($request, $response, $responseBody);
                $jsonPathResult = $this->jsonUtilService->processJSONPath($responseBody, $jsonPath);
                if (! is_string($jsonPathResult)) {
                    $jsonPathResult = json_encode($jsonPathResult, JSON_UNESCAPED_UNICODE);
                }
                $processedReturnArray['jsonPathResult'] = $jsonPathResult;
                return $processedReturnArray;
            }
        } catch (ConnectException $e) {
            return $this->constructionHttpPreExecutionResponseDataWithException($request, $e);
        } catch (RequestException $e) {
            return $this->constructionHttpPreExecutionResponseDataWithException($request, $e);
        }
    }

    private function constructionHttpPreExecutionResponseData(Request $request, Response $response, String $responseBody): array
    {
        // get request content as array
        $requestJsonArray = json_decode($request->getContent(), true);
        // get the response body and headers
        $responseHeaderProcessedArray = array();
        foreach ($response->getHeaders() as $name => $values) {
            $responseHeaderProcessedArray[$name] = implode('; ', $values);
        }
        $responseHeaders = $responseHeaderProcessedArray;
        $responseCode = $response->getStatusCode();
        // construct the response content
        $requestJsonArray['responseHeaders'] = $responseHeaders;
        $requestJsonArray['responseBody'] = $responseBody;
        $requestJsonArray['responseCode'] = $responseCode;
        return $requestJsonArray;
    }

    private function constructionHttpPreExecutionResponseDataWithException(Request $request, \RuntimeException $e): array
    {
        // get request content as array
        $requestJsonArray = json_decode($request->getContent(), true);
        // get the response body and headers
        $responseBody = $e->getMessage();
        $responseHeaderProcessedArray = array();
        $responseHeaders = $responseHeaderProcessedArray;
        $responseCode = 503;
        // construct the response content
        $requestJsonArray['responseHeaders'] = $responseHeaders;
        $requestJsonArray['responseBody'] = $responseBody;
        $requestJsonArray['responseCode'] = $responseCode;
        return $requestJsonArray;
    }

    private function generateUrl(string $url, $query = null)
    {
        if ($query == null || $query == '') {
            return $url;
        } else {
            return $url . '?' . $query;
        }
    }

    private function build_query(array $options = []): string
    {
        return build_query($options);
    }

    // -------- For web Service
    public function processWebServicePreExecution(Request $request): array
    {
        // get the fields for the web service execution
        $jsonRequest = json_decode($request->getContent());
        $dataJsonArray = array();
        // loop the json array
        if (! is_array($$jsonRequest)) {
            // convert body to array
            $jsonObjectRequest = json_decode($request->getContent(), true);
            array_push($dataJsonArray, $this->processHttpPreExecutionJsonRequest($request, $jsonObjectRequest));
        } else {
            $jsonArrayRequest = json_decode($request->getContent(), true);
            foreach ($$jsonArrayRequest as $jsonObjectRequest) {
                array_push($dataJsonArray, $this->processHttpPreExecutionJsonRequest($request, $jsonObjectRequest));
            }
        }
        $responseArray = [
            'metadate' => null,
            'data' => $dataJsonArray,
            'error' => null
        ];
        return $responseArray;
    }

    private function processWebServicePreExecutionJsonRequest(Request $request, array $jsonRequest): array
    {
        $method = $jsonRequest['method'];
        $baseUrl = $jsonRequest['baseUrl'];
        if (! filter_var($baseUrl, FILTER_VALIDATE_URL)) {
            $error = ValidationException::withMessages([
                'base url' => [
                    'The base url is no valid'
                ]
            ]);
            throw $error;
        }
        $wsdl = $baseUrl . '?WSDL';
        $argumentArray = $jsonRequest['argumentArray'];
        if (! is_array($argumentArray)) {
            $error = ValidationException::withMessages([
                '$argument array' => [
                    'The argument array is no an array'
                ]
            ]);
            throw $error;
        }
//        $nameSpace = $jsonRequest['nameSpace'];
//        $verificationMethod = $jsonRequest['verificationMethod'];
        $expectedValue = '';
        if (array_key_exists('expectedValue', $jsonRequest)) {
            $expectedValue = $jsonRequest['expectedValue'];
        }

        $client = new SoapClient($wsdl);
        $response = $client->__soapCall($method, $argumentArray);
        if (! isset($expectedValue) || trim($expectedValue) === '') {
            return $response;
        } else {
            return $response;
        }
    }

    // -------- For web Service
    public function processRedisPreExecution(Request $request): string
    {
        Log::info("excute===begin");
        $jsonObjContent = json_decode($request->getContent(), true);

//        $jsonPath = array_key_exists('jsonPath', $jsonObjContent) ? $jsonObjContent['jsonPath'] : null;
        $driverId = array_key_exists('driverId', $jsonObjContent) ? $jsonObjContent['driverId'] : null;
        $action = array_key_exists('action', $jsonObjContent) ? $jsonObjContent['action'] : null;

        // Redis_append,Redis_del,Redis_exists,Redis_get,Redis_hget,Redis_hgetAll,Redis_hlen,Redis_set
        $redisKey = array_key_exists('key', $jsonObjContent['data']) ? $jsonObjContent['data']['key'] : null;
        $redisValue = array_key_exists('value', $jsonObjContent['data']) ? $jsonObjContent['data']['value'] : null;
        $redisField = array_key_exists('field', $jsonObjContent['data']) ? $jsonObjContent['data']['field'] : null;

        $driverContent = new DriverMapper();
        $driverInfo = $driverContent->selectById([], $driverId);
        $driverProperty = json_decode($driverInfo)->data[0]->property;
        $driverPropertyArray = (array) $driverProperty;
        Log::info("==driver===property==" . json_encode($driverPropertyArray));

        $host = property_exists($driverProperty, "host") ? $driverProperty->host : null;
        $port = property_exists($driverProperty, "port") ? $driverProperty->port : 6379;
        $timeout = property_exists($driverProperty, "timeout") ? $driverProperty->timeout : null;
        $password = property_exists($driverProperty, "password") ? $driverProperty->password : null;
        $isCluster = property_exists($driverProperty, "Cluster") ? $driverProperty->Cluster : null;
        Log::info("===111=info===：" . $host . $port . $timeout . $password . $isCluster);

        if (! isset($host) || trim($host) === '') {
            $host = null;
        } else if (! isset($port) || trim($port) === '') {
            $port = null;
        } else if (! isset($timeout) || trim($timeout) === '') {
            $timeout = null;
        } else if (! isset($password) || trim($password) === '') {
            $password = null;
        } else if (! isset($isCluster) || trim($isCluster) === '') {
            $isCluster = null;
        }

        $this->redisconnect($isCluster, $host, $port, $timeout, $password);
        $data = $this->executeRedisAction($action, $redisKey, $redisValue, $redisField);
        Log::info("==redis=actionReturn==" . json_encode($data));

        $responseArray = [
            'metadate' => null,
            'data' => $data,
            'error' => null
        ];
        return json_encode($responseArray, JSON_UNESCAPED_UNICODE);
        // return $responseArray;
    }

    private function redisconnect($isCluster, $host, $port, $timeout, $password)
    {
        if (! $isCluster) {
            $redis = new Predis\Client([
                'host' => $host,
                'port' => $port,
                'password' => $password,
                'timeout' => $timeout
            ]);

            $redis->connect();
            $this->currentRedis = $redis;
            Log::info("====redis connect info===非集群：" . $host . $port . $timeout . $password);
        } else {
            $redisClusterList = [
                $host . ':' . $port
            ];
            if ($password != null) {
                $options = [
                    'cluster' => 'redis',
                    'parameters' => [
                        'password' => $password
                    ]
                ];
            } else {
                $options = [
                    'cluster' => 'redis'
                ];
            }

            $clusterRedis = new Predis\Client($redisClusterList, $options);
            $this->currentRedis = $clusterRedis;

            Log::info("====redis connect info===集群：" . $host . $port . $timeout . $password);
        }
    }

    private function executeRedisAction($action, $key, $value, $field): array
    {
        $redisActionReturn = false;
        $redisActionMsg = null;
        $redisActionData = null;
        switch (strtolower($action)) {
            case "redis_set":
                if ($key == null || empty($key) || $value == null) {
                    $redisActionMsg = "key or value is missing for executing the action : " . strtolower($action);
                    break;
                } else {
                    $redisActionData = $this->set($key, $value);
                    $redisActionReturn = true;
                    break;
                }
            case "redis_append":
                if ($key == null || empty($key) || $value == null) {
                    $redisActionReturn = false;
                    $redisActionMsg = "key or value is missing for executing the action : " . strtolower($action);
                    break;
                } else {
                    $redisActionData = $this->append($key, $value);
                    $redisActionReturn = true;
                    break;
                }
            case "redis_del":
                if ($key == null || empty($key)) {
                    $redisActionReturn = false;
                    $redisActionMsg = "key is missing for executing the action : " . strtolower($action);
                    break;
                } else {
                    $redisActionData = $this->del($key);
                    $redisActionReturn = true;
                    break;
                }
            case "redis_exists":
                if ($key == null || empty($key)) {
                    $redisActionReturn = false;
                    $redisActionMsg = "keyis missing for executing the action : " . strtolower($action);
                    break;
                } else {
                    $redisActionData = $this->exists($key);
                    $redisActionReturn = true;
                    break;
                }
            case "redis_get":
                if ($key == null || empty($key)) {
                    $redisActionReturn = false;
                    $redisActionMsg = "key or value is missing for executing the action : " . strtolower($action);
                    break;
                } else {
                    Log::info("-=-=-==");
                    $redisActionData = $this->get($key);
                    $redisActionReturn = true;
                    break;
                }
            case "redis_hget":
                if ($key == null || empty($key)) {
                    $redisActionReturn = false;
                    $redisActionMsg = "key is missing for executing the action : " . strtolower($action);
                    break;
                } else {
                    $redisActionData = $this->hget($key, $field);
                    $redisActionReturn = true;
                    break;
                }
            case "redis_hgetall":
                if ($key == null || empty($key)) {
                    $redisActionReturn = false;
                    $redisActionMsg = "key or value is missing for executing the action : " . strtolower($action);
                    break;
                } else {
                    $redisActionData = $this->hgetAll($key);
                    $redisActionReturn = true;
                    break;
                }
            case "redis_hlen":
                if ($key == null || empty($key)) {
                    $redisActionReturn = false;
                    $redisActionMsg = "key is missing for executing the action : " . strtolower($action);
                    break;
                } else {
                    $redisActionData = $this->hlen($key);
                    $redisActionReturn = true;
                    break;
                }
            default:
                $redisActionReturn = false;
                $redisActionMsg = "action" . $action . "is not supported";
                break;
        }

        // Log::info("redisActionData=origin==" . $redisActionData);
        Log::info("redisActionMsg===" . $redisActionMsg);
        $result = [];
        if ($redisActionReturn == true) {
            $result['action'] = $action;
            $result['key'] = $key;
            $result['value'] = $value;
            $result['field'] = $field;
            $result['redisActionReturn'] = $redisActionReturn;
            $result['redisActionData'] = $this->getString($redisActionData);
            // $result['redisActionData'] = (string)$redisActionData;
        } else {
            $result['action'] = $action;
            $result['key'] = $key;
            $result['value'] = $value;
            $result['field'] = $field;
            $result['redisActionReturn'] = $redisActionReturn;
            $result['redisActionMsg'] = $redisActionMsg;
        }
        Log::info("strig=====" . $result['redisActionData']);
        return $result;
    }

    private function getString($value)
    {
        Log::info("111" . gettype($value));
        if (is_array($value)) {
            // return json_encode($value,true);
            Log::info("111===" . json_encode($value, JSON_UNESCAPED_UNICODE));
            Log::info($value);
            foreach ($value as $key => $val) {
                if (gettype($val) == "string" && $this->is_array($val)) {
                    $value[$key] = json_decode($val, true);
                    Log::info($key);
                }
            }
            return json_encode($value, JSON_UNESCAPED_UNICODE);
        } else {
            Log::info($value);
            $res = (string) $value;
            // return utf8_encode($res);
            return mb_convert_encoding($res, 'UTF-8', 'UTF-8');
        }
    }

    private function is_array($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    private function set($key, $value)
    {
        return $this->currentRedis->set($key, $value);
    }

    private function get($key)
    {
        return $this->currentRedis->get($key);
    }

    private function del($key)
    {
        return $this->currentRedis->del($key);
    }

    private function append($key, $value)
    {
        return $this->currentRedis->append($key, $value);
    }

    private function exists($key)
    {
        return $this->currentRedis->exists($key);
    }

    private function hget($key, $field)
    {
        return $this->currentRedis->hget($key, $field);
    }

    private function hgetAll($key)
    {
        return $this->currentRedis->hgetAll($key);
    }

    private function hlen($key)
    {
        return $this->currentRedis->hlen($key);
    }
}
