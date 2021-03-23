<?php

namespace App\Services\Utils\Verification;

use Illuminate\Validation\ValidationException;

class TextVerificationUtilService
{
    public function verifyText (string $source, string $expectedValue, string $method = 'equal') : array {
        $returnArray = array();
        if (!is_string($source)) {
            $error = ValidationException::withMessages([
                'source' => ['the source is not string']
            ]);
            throw $error;
        }
        $returnArray['source'] = $source;
        $returnArray['expectedValue'] = $expectedValue;
        $returnArray['type'] = 'text';
        $returnArray['method'] = $method;
        if (is_null($expectedValue)) {
            $returnArray['result'] = false;
        }
        elseif (!is_string($expectedValue)) {
            $error = ValidationException::withMessages([
                'expectedValue' => ['the expected value is not string']
            ]);
            throw $error;
        }
        if (strcmp($expectedValue, $source) !== 0) {
            $returnArray['result'] = false;
        }
        else {
            $returnArray['result'] = true;
        }
        return $returnArray;
    }
}