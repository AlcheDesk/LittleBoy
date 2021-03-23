<?php
namespace App\Http\Controllers\API\ATM;

use App\Http\Controllers\API\MeowlomoBaseController;
use App\Http\Controllers\API\MeowlomoBaseControllerInterface;
use App\Services\ATM\TestCaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestCaseController extends MeowlomoBaseController implements MeowlomoBaseControllerInterface {

	private $baseService;

	public function __construct() {
		$this->baseService = new TestCaseService();
	}

	public function deleteByCondition(Request $request) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->baseService->deleteByCondition($request);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function deleteById(Request $request, $id) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->baseService->deleteById($id);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function insert(Request $request) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->baseService->insert($request);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function selectByCondition(Request $request) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->baseService->selectByCondition($request);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function selectById(Request $request, $id) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->baseService->selectById($request, $id);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function update(Request $request) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->baseService->update($request);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function replace(Request $request) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		// get the Model objects from mapper layer
		$jsonStringResponse = $this->baseService->replace($request);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	// 关联接口
	public function getInstructionByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->getInstructionByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function deleteInstructionByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->deleteInstructionByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function insertInstructionByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->insertInstructionByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function updateInstructionByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->updateInstructionByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function getStorageByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->getStorageByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function deleteStorageByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->deleteStorageByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function insertStorageByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->insertStorageByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function updateStorageByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->updateStorageByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function replaceStorageByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->replaceStorageByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	// drivers by testCase
	public function getDriverByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->getDriverByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function deleteDriverByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->deleteDriverByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function insertDriverByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->insertDriverByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function updateDriverByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->updateDriverByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function replaceDriverByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->replaceDriverByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	// systemRequirements by testCase
	public function getSystemRequirementByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->getSystemRequirementByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function deleteSystemRequirementByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->deleteSystemRequirementByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function insertSystemRequirementByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->insertSystemRequirementByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function updateSystemRequirementByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->updateSystemRequirementByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function replaceSystemRequirementByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->replaceSystemRequirementByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	// testCaseOptions by testCase
	public function getTestCaseOptionByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->getTestCaseOptionByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function deleteTestCaseOptionByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->deleteTestCaseOptionByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function insertTestCaseOptionByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->insertTestCaseOptionByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function updateTestCaseOptionByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->updateTestCaseOptionByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function replaceTestCaseOptionByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->replaceTestCaseOptionByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	// runs by testCase
	public function getRunByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->getRunByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function deleteRunByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->deleteRunByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function insertRunByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->insertRunByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function updateRunByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->updateRunByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function replaceRunByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->replaceOrInsertRunByTestCase($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function replaceRunByTestCaseIdAndRunId(Request $request, $testCaseId, $runId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->replaceRunByTestCaseIdAndRunId($request, $testCaseId, $runId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function deleteRunByTestCaseIdAndRunId(Request $request, $testCaseId, $runId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->deleteRunByTestCaseIdAndRunId($testCaseId, $runId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	// tag by testCase
	public function getTagByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->getTagByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function deleteTagByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->deleteTagByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function insertTagByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->insertTagByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function updateTagByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->updateTagByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function replaceTagByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->replaceTagByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	// others
	public function getTestCaseFolderByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->getTestCaseFolderByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function getProjectByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->getProjectByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function getTaskByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->getTaskByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function getDriverPackByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->getDriverPackByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function getExecutionDriverMapByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->getExecutionDriverMapByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function getInstructionOverwriteByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->getInstructionOverwriteByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function getTestCaseOverwriteByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->getTestCaseOverwriteByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	public function insertTestCaseOverwriteByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->insertTestCaseOverwriteByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}

	//runExecutionInfo
	public function getRunExecutionInfoByTestCaseId(Request $request, $testCaseId) {
		$bodyContent = $request->getContent();
		// check the body is json
		json_decode($bodyContent);
		if (!in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
			return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
		}
		$jsonStringResponse = $this->baseService->getRunExecutionInfoByTestCaseId($request, $testCaseId);

		Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
		return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
	}
}
