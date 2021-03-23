<?php
namespace App\Http\Controllers\API\ATM;

use App\Http\Controllers\API\MeowlomoBaseController;
use App\Services\ATM\PreExecutionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PreExecutionController extends MeowlomoBaseController {

	private $baseService;

	public function __construct() {
		$this->baseService = new PreExecutionService();
	}

	public function PreExecutionCall(Request $request) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$bodyContent = $request->getContent();
		// check the string is json
		json_decode($bodyContent);
		if (json_last_error() == JSON_ERROR_NONE) {
			// the body is a json
			// get the body as json
			$jsonObjContent = json_decode($bodyContent, true);
			$jsonStringResponse = '';
			switch (strtolower($jsonObjContent['type'])) {
			case 'restapi':
				$jsonStringResponse = $this->baseService->processRestApiPreExecution($request);
				Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
				return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
			case 'redis':
				$jsonStringResponse = $this->baseService->processRedisPreExecution($request);
				Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
				return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
			default:
				$responseContent = array(
					"message" => "missing type in the json",
					"request" => $bodyContent,
				);
				Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($responseContent, true));
				return response($responseContent, 400)->header('Content-Type', 'application/json; charset=utf8');
			}
		} else {
			// the body is no a json
			$responseContent = array(
				"message" => "the request body is not a json",
				"request" => $bodyContent,
			);
			Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($responseContent, true));
			return response($responseContent, 400)->header('Content-Type', 'application/json; charset=utf8');
		}
	}

	public function HttpPreExecutionCall(Request $request) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$bodyContent = $request->getContent();
		// check the string is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), array(
			"GET",
			"HEAD",
			"OPTIONS",
			"DELETE",
		)) && json_last_error() == JSON_ERROR_NONE) {
			// the body is a json
			// get the body as json
			$jsonStringResponse = $this->baseService->processHttpPreExecution($request);
			Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
			return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
		} else {
			// the body is no a json
			$responseContent = array(
				"message" => "the request body is not a json",
				"request" => $bodyContent,
			);
			Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($responseContent, true));
			return response($responseContent, 400)->header('Content-Type', 'application/json; charset=utf8');
		}
	}

	public function WebServicePreExecutionCall(Request $request) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$bodyContent = $request->getContent();
		// check the string is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), array(
			"GET",
			"HEAD",
			"OPTIONS",
			"DELETE",
		)) && json_last_error() == JSON_ERROR_NONE) {
			// the body is a json
			// get the body as json
			$jsonStringResponse = $this->baseService->processWebServicePreExecution($request);
			Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
			return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
		} else {
			// the body is no a json
			$responseContent = array(
				"message" => "the request body is not a json",
				"request" => $bodyContent,
			);
			Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($responseContent, true));
			return response($responseContent, 400)->header('Content-Type', 'application/json; charset=utf8');
		}
	}

	public function RedisExecutionCall(Request $request) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$bodyContent = $request->getContent();
		// check the string is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), array(
			"GET",
			"HEAD",
			"OPTIONS",
			"DELETE",
		)) && json_last_error() == JSON_ERROR_NONE) {
			// the body is a json
			// get the body as json
			$jsonStringResponse = $this->baseService->processRedisPreExecution($request);
			Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
			return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
		} else {
			// the body is no a json
			$responseContent = array(
				"message" => "the request body is not a json",
				"request" => $bodyContent,
			);
			Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($responseContent, true));
			return response($responseContent, 400)->header('Content-Type', 'application/json; charset=utf8');
		}
	}
}