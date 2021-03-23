<?php

namespace App\Services\ATM;

use App\Mappers\ATM\ExportMapper;
use App\Mappers\ATM\TestCaseMapper;
use App\Services\Utils\RedisUtils\ATM\ExportRedisUtilService;
use App\Services\Utils\RedisUtils\Common\GenerateRedisKeyService;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Exports\InvoicesExport;
use Maatwebsite\Excel\Excel;
use App\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;

class ExportService
{

    private $mapper;

    public function __construct()
    {
        $this->mapper = new ExportMapper();
    }

    public function exportExcelTestCase(Request $request, $id) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->exportExcelTestCase($this->mapper->parse_query($request->getQueryString()), $id);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function exportExcelRunSet(Request $request, $id) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->exportExcelRunSet($this->mapper->parse_query($request->getQueryString()), $id);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function exportExcelProject(Request $request, $id) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->exportExcelProject($this->mapper->parse_query($request->getQueryString()), $id);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }

    public function exportExcelRunSetResult(Request $request, $id) : string
    {
        // get the Model objects from mapper layer
        $jsonStringResponse = $this->mapper->exportExcelRunSetResult($this->mapper->parse_query($request->getQueryString()), $id);
        Log::debug('Service layer ' . __CLASS__ . ' ' . __FUNCTION__ . ' return ' . var_export($jsonStringResponse, true));
        return $jsonStringResponse;
    }
}
