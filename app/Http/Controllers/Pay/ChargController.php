<?php

namespace App\Http\Controllers\Pay;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ChargController extends Controller
{

     public function getTestcaseResultTimeByRunId(Request $request, $runId)
    {
        $jsonStringResponse = $this->baseService->getInstructionResultByRunId($request, $runId);

        Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
    }
}
