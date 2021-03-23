<?php
/**
 * Created by PhpStorm.
 * User: tryndamere.wang
 * Date: 2018/12/18
 * Time: 15:19
 */
namespace App\Services\ATM;

use App\Mappers\ATM\ApiUnitCallMapper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiUnitCallService
{

    private $mapper;

    public function __construct()
    {
        $this->mapper = new ApiUnitCallMapper();
    }

    public function apiUnitCall(Request $request) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->apiUnitCall($request->getContent());
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }
}
