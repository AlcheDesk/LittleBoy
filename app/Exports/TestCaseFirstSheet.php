<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TestCaseFirstSheet implements WithTitle, FromArray, ShouldAutoSize
{
    private $testCaseArray;

    public function __construct($testCaseArray)
    {
        $this->testCaseArray  = $testCaseArray;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return  'testCases';
    }

    public function array(): array
    {
        $testCaseArray=$this->testCaseArray['testCases'];
        $firtLine= ['用例编号', '用例名称', '创建时间','备注','用例类型'];
        // $testCaseRecord =array();
        $testCaseRecord[]=$firtLine;
        for ($i = 0; $i < sizeof($testCaseArray); $i++) {
          if(isset($testCaseArray[$i])&&is_array($testCaseArray[$i])){
                    $otherLine=array();
                    $testCase=$testCaseArray[$i];
                    if(isset($testCase['id'])){
                        $otherLine[]=$testCase['id'];
                    }else{
                        $otherLine[]='';
                    }
                    if(isset($testCase['name'])){
                        $otherLine[]=$testCase['name'];
                    }else{
                        $otherLine[]='';
                    }
                    if(isset($testCase['createdAt'])){
                        $otherLine[]=$testCase['createdAt'];
                    }else{
                        $otherLine[]='';
                    }
                    if(isset($testCase['comment'])){
                        $otherLine[]=$testCase['comment'];
                    }else{
                        $otherLine[]='';
                    }
                    if(isset($testCase['type'])){
                        $otherLine[]=$testCase['type'];
                    }else{
                        $otherLine[]='';
                    }
                    $testCaseRecord[]=$otherLine;
                }
          }
        return $testCaseRecord;
    }

}
