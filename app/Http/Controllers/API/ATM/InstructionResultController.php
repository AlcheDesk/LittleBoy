<?php
namespace App\Http\Controllers\API\ATM;

use App\Http\Controllers\API\MeowlomoBaseControllerInterface;
use App\Http\Controllers\API\MeowlomoBaseController;
use App\Services\ATM\InstructionResultService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InstructionResultController extends MeowlomoBaseController implements MeowlomoBaseControllerInterface
{

    private $baseService;

    public function __construct()
    {
        $this->baseService = new InstructionResultService();
    }

    public function deleteByCondition(Request $request)
    {
        $bodyContent = $request->getContent();
        // check the body is json
        json_decode($bodyContent);
        if (! in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
            return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
        }
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->baseService->deleteByCondition($request);

        Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

    public function deleteById(Request $request, $id)
    {
        $bodyContent = $request->getContent();
        // check the body is json
        json_decode($bodyContent);
        if (! in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
            return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
        }
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->baseService->deleteById($id);

        Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

    public function insert(Request $request)
    {
        $bodyContent = $request->getContent();
        // check the body is json
        json_decode($bodyContent);
        if (! in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
            return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
        }
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->baseService->insert($request);

        Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

    public function selectByCondition(Request $request)
    {
        $bodyContent = $request->getContent();
        // check the body is json
        json_decode($bodyContent);
        if (! in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
            return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
        }
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->baseService->selectByCondition($request);

        Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

    public function selectById(Request $request, $id)
    {
        $bodyContent = $request->getContent();
        // check the body is json
        json_decode($bodyContent);
        if (! in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
            return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
        }
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->baseService->selectById($request, $id);

        Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

    public function update(Request $request)
    {
        $bodyContent = $request->getContent();
        // check the body is json
        json_decode($bodyContent);
        if (! in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
            return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
        }
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->baseService->update($request);

        Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

    public function replace(Request $request)
    {
        $bodyContent = $request->getContent();
        // check the body is json
        json_decode($bodyContent);
        if (! in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
            return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
        }
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->baseService->replace($request);

        Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

    // 关联接口
    public function insertFileByInstructionResultId(Request $request, $instructionResultId)
    {
        $bodyContent = $request->getContent();
        // check the body is json
        json_decode($bodyContent);
        if (! in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
            return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
        }
        $jsonStringResponse = $this->baseService->insertFileByInstructionResultId($request, $instructionResultId);

        Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

    public function getFileByInstructionResultId(Request $request, $instructionResultId)
    {
        $bodyContent = $request->getContent();
        // check the body is json
        json_decode($bodyContent);
        if (! in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
            return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
        }
        $jsonStringResponse = $this->baseService->getFileByInstructionResultId($request, $instructionResultId);

        Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

    public function updateFileByInstructionResultId(Request $request, $instructionResultId)
    {
        $bodyContent = $request->getContent();
        // check the body is json
        json_decode($bodyContent);
        if (! in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
            return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
        }
        $jsonStringResponse = $this->baseService->updateFileByInstructionResultId($request, $instructionResultId);

        Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

    public function insertStepLogByInstructionResultId(Request $request, $instructionResultId)
    {
        $bodyContent = $request->getContent();
        // check the body is json
        json_decode($bodyContent);
        if (! in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
            return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
        }
        $jsonStringResponse = $this->baseService->insertStepLogByInstructionResultId($request, $instructionResultId);

        Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

    public function getStepLogByInstructionResultId(Request $request, $instructionResultId)
    {
        $bodyContent = $request->getContent();
        // check the body is json
        json_decode($bodyContent);
        if (! in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
            return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
        }
        $jsonStringResponse = $this->baseService->getStepLogByInstructionResultId($request, $instructionResultId);

        Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

    public function updateStepLogByInstructionResultId(Request $request, $instructionResultId)
    {
        $bodyContent = $request->getContent();
        // check the body is json
        json_decode($bodyContent);
        if (! in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
            return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
        }
        $jsonStringResponse = $this->baseService->updateStepLogByInstructionResultId($request, $instructionResultId);

        Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

    public function insertExecutionLogByInstructionResultId(Request $request, $instructionResultId)
    {
        $bodyContent = $request->getContent();
        // check the body is json
        json_decode($bodyContent);
        if (! in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
            return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
        }
        $jsonStringResponse = $this->baseService->insertExecutionLogByInstructionResultId($request, $instructionResultId);

        Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

    public function getExecutionLogByInstructionResultId(Request $request, $instructionResultId)
    {
        $bodyContent = $request->getContent();
        // check the body is json
        json_decode($bodyContent);
        if (! in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
            return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
        }
        $jsonStringResponse = $this->baseService->getExecutionLogByInstructionResultId($request, $instructionResultId);

        Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

    public function updateExecutionLogByInstructionResultId(Request $request, $instructionResultId)
    {
        $bodyContent = $request->getContent();
        // check the body is json
        json_decode($bodyContent);
        if (! in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
            return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
        }
        $jsonStringResponse = $this->baseService->updateExecutionLogByInstructionResultId($request, $instructionResultId);

        Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

    public function getRunByInstructionResultId(Request $request, $instructionResultId)
    {
        $bodyContent = $request->getContent();
        // check the body is json
        json_decode($bodyContent);
        if (! in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
            return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
        }
        $jsonStringResponse = $this->baseService->getRunByInstructionResultId($request, $instructionResultId);

        Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
    }
}
