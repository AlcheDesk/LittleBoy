<?php
namespace App\Http\Controllers\UI\ATM;

use App\Http\Controllers\API\MeowlomoBaseControllerInterface;
use App\Http\Controllers\API\MeowlomoBaseController;
use App\Services\ATM\ExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Exports\TestCaseExport;
use App\Exports\RunSetExport;
use App\Exports\ProjectExport;
use App\Exports\RunSetResultExport;
use Excel;

class ExportController extends MeowlomoBaseController 
{

    private $exportService;
    private $excel;

    public function __construct(Excel $excel)
    {
        $this->exportService = new ExportService();
        $this->excel = $excel;
    }

    public function exportExcelTestCase(Request $request, $testCaseId)
    {
        // avoid cant open xlsx or xls issue, https://github.com/Maatwebsite/Laravel-Excel/issues/202
        ob_end_clean();
        ob_start();
        $testCasesResponseStr = $this->exportService->exportExcelTestCase($request, $testCaseId);
        $testCasesResponse = json_decode($testCasesResponseStr, true);
        $testCaseArray = $testCasesResponse['data'];
        if(sizeof($testCaseArray)>0){
            return (new TestCaseExport($testCaseArray))->download($testCaseArray[0]['name'].'.xlsx');
        }else{
            return null;
        }
    }

    public function exportExcelRunSet(Request $request, $runSetId)
    {
        // avoid cant open xlsx or xls issue
        ob_end_clean();
        ob_start();
        $runSetsResponseStr = $this->exportService->exportExcelRunSet($request, $runSetId);
        $runSetsResponse = json_decode($runSetsResponseStr, true);
        $runSetArray = $runSetsResponse['data'];
        if(sizeof($runSetArray)>0){
            return (new RunSetExport($runSetArray))->download($runSetArray[0]['name'].'.xlsx');
        }else{
            return null;
        }
    }

    public function exportExcelProject(Request $request, $projectId)
    {
        // avoid cant open xlsx or xls issue
        ob_end_clean();
        ob_start();
        $projectsResponseStr = $this->exportService->exportExcelProject($request, $projectId);
        $projectsResponse = json_decode($projectsResponseStr, true);
        $projectArray = $projectsResponse['data'];
        if(sizeof($projectArray)>0){
            return (new ProjectExport($projectArray))->download($projectArray[0]['name'].'.xlsx');
        }else{
            return null;
        }
    }

    public function exportExcelRunSetResult(Request $request, $runSetResultId)
    {
        // avoid cant open xlsx or xls issue
        ob_end_clean();
        ob_start();
        $runSetResultsResponseStr = $this->exportService->exportExcelRunSetResult($request, $runSetResultId);
        $runSetResultsResponse = json_decode($runSetResultsResponseStr, true);
        $runSetResultArray = $runSetResultsResponse['data'];
        if(sizeof($runSetResultArray)>0){
            return (new RunSetResultExport($runSetResultArray))->download($runSetResultArray[0]['name'].'.xlsx');
        }else{
            return null;
        }
    }
}
