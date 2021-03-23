<?php
namespace App\Http\Controllers\API\ATM;

use App\Http\Controllers\API\MeowlomoBaseController;
use App\Services\ATM\ProjectExecutionInfoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectExecutionInfoController extends MeowlomoBaseController {

	private $baseService;

	public function __construct() {
	    $this->baseService = new ProjectExecutionInfoService();
	}

	//projectExecutionInfo
	public function getProjectExecutionInfo(Request $request) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->getProjectExecutionInfo($request);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function getProjectExecutionInfoById(Request $request, $projectId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->getProjectExecutionInfoById($request, $projectId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}
	
	public function getTestCaseExecutionInfoByProjectId(Request $request, $projectId) {
	    $bodyContent = $request->getContent();
	    // check the body is json
	    json_decode($bodyContent);
	    if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
	        return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
	    }
	    $jsonStringResponse = $this->baseService->getTestCaseExecutionInfoByProjectId($request, $projectId);
	    
	    Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
	    return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}
}
