<?php
namespace app\Services\ATM;

use App\Services\Utils\Verification\JsonPathVerificationUtilService;
use App\Services\Utils\Verification\TextVerificationUtilService;
use function GuzzleHttp\json_encode;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VerificationService
{
    private $textVerificationUtilService;
    private $jsonPathVerificationUtilService;
    
    public function __construct()
    {
        $this->textVerificationUtilService = new TextVerificationUtilService();
        $this->jsonPathVerificationUtilService = new JsonPathVerificationUtilService();
    }
    
    public function verify (Request $request) : string {
        //get the fields for the http execution
        $jsonObjContent = json_decode($request->getContent());
        //loop the json array
        if (!is_array($jsonObjContent)) {
            $jsonObjContent = json_decode($request->getContent(), true);
        }
        //check the type of the request
        $type = $jsonObjContent['type'];
        if (!isset($type) || trim($type) === '') {
            $error = ValidationException::withMessages([
                'type' => ['the source is not string or missing']
            ]);
            throw $error;
        }
        $method = 'equal';
        if (array_key_exists('method', $jsonObjContent)){
            $method = $jsonObjContent['method'];
        }
        $verifyResultArray = null;
        $source = $jsonObjContent['source'];
        $expectedValue = null;
        if (array_key_exists('expectedValue', $jsonObjContent)){
            $expectedValue = $jsonObjContent['expectedValue'];
        }
        $jsonPath = null;
        if (array_key_exists('jsonPath', $jsonObjContent)){
            $jsonPath = $jsonObjContent['jsonPath'];
        }
        //iconv(mb_detect_encoding($source, mb_detect_order(), true), "UTF-8", $source);
        switch (strtolower($type)){
            case "text":
                $verifyResultArray = $this->textVerificationUtilService->verifyText ($source, $expectedValue, $method);
                break;
            case "jsonpath":
                $verifyResultArray = $this->jsonPathVerificationUtilService->verifyJSONPath ($source, $expectedValue, $jsonPath, $method);
                break;
            default:
                $error = ValidationException::withMessages([
                'type' => ['the type is not supported ' . $type]
                ]);
                throw $error;
                
        }
        $responseArray = ['metadate' => null, 'data' => $verifyResultArray, 'error' => null];
        return json_encode($responseArray, JSON_UNESCAPED_UNICODE);
    }
}

