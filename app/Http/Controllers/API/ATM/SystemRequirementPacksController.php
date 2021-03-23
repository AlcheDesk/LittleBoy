<?php
namespace App\Http\Controllers\API\ATM;

use App\Http\Controllers\API\MeowlomoBaseControllerInterface;
use App\Http\Controllers\API\MeowlomoBaseController;
use App\Services\ATM\SystemRequirementPacksService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SystemRequirementPacksController extends MeowlomoBaseController implements MeowlomoBaseControllerInterface
{

    private $baseService;

    public function __construct()
    {
        $this->baseService = new SystemRequirementPacksService();
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
        $jsonStringResponse = $this->baseService->deleteById($request, $id);

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
    public function getSystemRequirementsBySystemRequirementPackId(Request $request, $systemRequirementPackId)
    {
        $bodyContent = $request->getContent();
        // check the body is json
        json_decode($bodyContent);
        if (! in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
            return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
        }
        $jsonStringResponse = $this->baseService->getSystemRequirementsBySystemRequirementPackId($request, $systemRequirementPackId);

        Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
    }
    
    public function deleteSystemRequirementsBySystemRequirementPackId(Request $request, $systemRequirementPackId)
    {
        $bodyContent = $request->getContent();
        // check the body is json
        json_decode($bodyContent);
        if (! in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
            return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
        }
        $jsonStringResponse = $this->baseService->deleteSystemRequirementsBySystemRequirementPackId($request, $systemRequirementPackId);

        Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
    }
    
    public function insertSystemRequirementsBySystemRequirementPackId(Request $request, $systemRequirementPackId)
    {
        $bodyContent = $request->getContent();
        // check the body is json
        json_decode($bodyContent);
        if (! in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
            return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
        }
        $jsonStringResponse = $this->baseService->insertSystemRequirementsBySystemRequirementPackId($request, $systemRequirementPackId);

        Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
    }
    
    public function replaceSystemRequirementsBySystemRequirementPackId(Request $request, $systemRequirementPackId)
    {
        $bodyContent = $request->getContent();
        // check the body is json
        json_decode($bodyContent);
        if (! in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
            return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
        }
        $jsonStringResponse = $this->baseService->replaceSystemRequirementsBySystemRequirementPackId($request, $systemRequirementPackId);

        Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
    }
}
