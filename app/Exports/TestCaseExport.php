<?php

namespace App\Exports;

use App\Invoice;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TestCaseExport implements WithMultipleSheets
{

    use Exportable;

    protected $testCaseArray;
    
    public function __construct(array $testCaseArray)
    {
        $this->testCaseArray = $testCaseArray;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        for ($i = 0; $i < 1; $i++) {
            $sheets[] = new InstructionFirstSheet($this->testCaseArray[$i]);
        }
        return $sheets;
    }

}