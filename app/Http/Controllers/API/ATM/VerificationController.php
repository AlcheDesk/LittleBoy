<?php
namespace App\Http\Controllers\API\ATM;

use App\Http\Controllers\API\MeowlomoBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use app\Services\ATM\VerificationService;

class VerificationController extends MeowlomoBaseController
{

    private $baseService;

    public function __construct()
    {
        $this->baseService = new VerificationService();
    }

    public function verify(Request $request)
    {
        $bodyContent = $request->getContent();
        // check the body is json
        json_decode($bodyContent);
        if (! in_array($request->getMethod(), $this->noRequestBodyHttpMethod) && json_last_error() !== JSON_ERROR_NONE) {
            return $this->invalidJsonRequestCall(__CLASS__, __FUNCTION__);
        }

        $bodyContent = $request->getContent();
        Log::info($bodyContent);
        // check the string is json
        json_decode($bodyContent);
        if (json_last_error() == JSON_ERROR_NONE) { // the body is a json
                                                    // get the body as json
            $jsonStringResponse = $this->baseService->verify($request);
            // iconv(mb_detect_encoding($jsonStringResponse, mb_detect_order(), true), "UTF-8", $jsonStringResponse);
            return response($jsonStringResponse, 200)->header('Content-Type', 'application/json; charset=utf8');
        } else { // the body is no a json
            $responseContent = array(
                "message" => "the request body is not a json",
                "request" => $bodyContent
            );
            Log::debug('Controller layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($responseContent, true));
            return response($responseContent, 400)->header('Content-Type', 'application/json; charset=utf8');
        }
    }
}