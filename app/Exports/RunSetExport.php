<?php

namespace App\Exports;

use App\Invoice;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RunSetExport implements WithMultipleSheets
{

    use Exportable;

    protected $runSetArray;
    
    public function __construct(array $runSetArray)
    {
        $this->runSetArray = $runSetArray;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $runSetObj=$this->runSetArray[0];
        $testCaseArray=$runSetObj['testCases'];
        // order testCase by defauld id desc
        $testCaseArray = $testCaseArray;
        foreach($testCaseArray as $value) $r[] = $value['id'];
        array_multisort($r,SORT_DESC, $testCaseArray);
        $runSetObj['testCases']=$testCaseArray;
        $sheets[] = new TestCaseFirstSheet($runSetObj);
        for ($i = 0; $i < sizeof($testCaseArray); $i++) {
            $testCaseObj=$testCaseArray[$i];
            $sheets[] = new TestCaseSheet($testCaseObj);
        }
        return $sheets;
    }

}