<?php

namespace App\Services\Utils\Verification;

use Illuminate\Validation\ValidationException;


class RegexVerificationUtilService
{
    public function verifyJSONPath (string $source, string $regex) {
        $returnArray = array();
        if (!is_string($source)) {
            $error = ValidationException::withMessages([
                'source' => ['the source is not string']
            ]);
            throw $error;
        }
        if (!is_string($regex)) {
            $error = ValidationException::withMessages([
                'regex' => ['the regex is not string']
            ]);
            throw $error;
        }
        $returnArray['source'] = $source;
        $returnArray['regex'] = $regex;

        if (preg_match($regex, $source) !== 1) {
            $returnArray['result'] = false;
        }
        else {
            $returnArray['result'] = true;
        } 
        return $returnArray;
    }
}