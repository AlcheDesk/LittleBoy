<?php
namespace App\Http\Controllers\API\ATM;

use App\Http\Controllers\API\MeowlomoBaseController;
use App\Services\ATM\TestCaseTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

// implements MLController
class TestCaseTypeController extends MeowlomoBaseController
{

    private $baseService;

    public function __construct()
    {
        $this->baseService = new TestCaseTypeService();
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
}
