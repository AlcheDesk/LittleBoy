<?php

namespace App\Exports;

use App\Invoice;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProjectExport implements WithMultipleSheets
{

    use Exportable;

    protected $projectArray;
    
    public function __construct(array $projectArray)
    {
        $this->projectArray = $projectArray;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $projectObj=$this->projectArray[0];
        $testCaseArray=$projectObj['testCases'];
        // order testCase by defauld id desc
        $testCaseArray = $testCaseArray;
        foreach($testCaseArray as $value) $r[] = $value['id'];
        array_multisort($r,SORT_DESC, $testCaseArray);
        $projectObj['testCases']=$testCaseArray;
        $sheets[] = new TestCaseFirstSheet($projectObj);
        for ($i = 0; $i < sizeof($testCaseArray); $i++) {
            $testCaseObj=$testCaseArray[$i];
            $sheets[] = new TestCaseSheet($testCaseObj);
        }
        return $sheets;
    }

}