<?php
/**
 * User: tryndamere.wang
 * Date: 2018/12/20
 * Time: 10:39
 */
namespace App\Services\ATM;

use App\Mappers\ATM\TerminationMapper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TerminationService
{

    private $mapper;

    public function __construct()
    {
        $this->mapper = new TerminationMapper();
    }

    public function terminationTestCaseRunById(Request $request, $id) : string
    {
        $jsonStringResponse = $this->mapper->terminationTestCaseRunById($id);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function terminationRunSetResultRunById(Request $request, $id) : string
    {
        $jsonStringResponse = $this->mapper->terminationRunSetResultRunById($id);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }
}
