<?php

namespace App\Services\Utils;

use Flow\JSONPath\JSONPath;

class JsonPathUtilService
{
    public function processJSONPath (string $data, $jsonPath) {
        json_decode($data);
        if (json_last_error() != JSON_ERROR_NONE) {
            return '';
        }
        return (new JSONPath(json_decode($data, true)))->find($jsonPath)->data();
    }
    
    public function findFirst(string $data, $jsonPath){
        json_decode($data);
        if (json_last_error() == JSON_ERROR_NONE) {
            return '';
        }
        return (new JSONPath(json_decode($data, true)))->first($jsonPath);
    }
    
    public function findLast(string $data, $jsonPath){
        json_decode($data);
        if (json_last_error() == JSON_ERROR_NONE) {
            return '';
        }
        return (new JSONPath(json_decode($data, true)))->last($jsonPath);
    }
}