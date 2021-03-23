<?php

namespace App\Exports;

use App\Invoice;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RunSetResultExport implements WithMultipleSheets
{

    use Exportable;

    protected $runSetResultArray;
    
    public function __construct(array $runSetResultArray)
    {
        $this->runSetResultArray = $runSetResultArray;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $runSetResultObj=$this->runSetResultArray[0];
        $runArray=$runSetResultObj['runs'];
        // order run by defauld id desc
        // foreach($runArray as $value) $r[] = $value['id'];
        // array_multisort($r,SORT_DESC, $runArray);
        // $runSetResultObj['runs']=$runArray;
        $sheets[] = new RunFirstSheet($runSetResultObj);
        for ($i = 0; $i < sizeof($runArray); $i++) {
            $runObj=$runArray[$i];
            $sheets[] = new RunSheet($runObj);
        }
        return $sheets;
    }

}