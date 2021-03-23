<?php

namespace App\Services\Utils\Verification;

use Flow\JSONPath\JSONPath;
use Illuminate\Validation\ValidationException;


class JsonPathVerificationUtilService
{
    public function verifyJSONPath (string $source, $expectedValue, string $jsonPath, string $method = 'equal') : array {
        $returnArray = array();
        if (!is_string($source)) {
            $error = ValidationException::withMessages([
                'source' => ['the source is not string']
            ]);
            throw $error;
        }
        json_decode($source);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $error = ValidationException::withMessages([
                'source' => ['the source is not a valid json']
            ]);
            throw $error;
        }
        if (!is_string($jsonPath)) {
            $error = ValidationException::withMessages([
                'json path' => ['the json path is not string']
            ]);
            throw $error;
        }
        $returnArray['source'] = $source;
        $returnArray['jsonPath'] = $jsonPath;
        $returnArray['expectedValue'] = $expectedValue;
        $returnArray['type'] = 'jsonPath';
        
        $jsonPathResult =  null;
        try{
            $jsonPathResult = (new JSONPath(json_decode($source, true)))->find($jsonPath)->data();
        } 
        catch (\Exception $e) 
        {
            $error = ValidationException::withMessages([
                'json path' => ['the json path is not in a valid format :'. $e->getMessage()]
            ]);
            throw $error;
        }
        if (is_array($jsonPathResult) && !empty($jsonPathResult)) {
            //$jsonPathResult = json_encode($jsonPathResult, JSON_UNESCAPED_UNICODE);
            $jsonPathResult = $jsonPathResult[0];
            if (!is_string($jsonPathResult)) {
                    $jsonPathResult = strval($jsonPathResult);
            }
            $returnArray['output'] = $jsonPathResult;
            if (is_null($expectedValue)) {
                $returnArray['result'] = false;
            }
            elseif (!is_string($expectedValue)) {
                $error = ValidationException::withMessages([
                    'expectedValue' => ['the expected value is not string']
                ]);
                throw $error;
            }
            if (strcmp($expectedValue, $jsonPathResult) !== 0) {
                $returnArray['result'] = false;
            }
            else {
                $returnArray['result'] = true;
            } 
        }
        else{
            $returnArray['output'] = null;
            $returnArray['result'] = false;
        }
        return $returnArray;
    }
}