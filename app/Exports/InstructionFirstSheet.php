<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InstructionFirstSheet implements WithTitle, FromArray, ShouldAutoSize
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
        return  'instructions';
    }

    public function array(): array
    {
        $instructionArray=$this->testCaseArray['instructions'];
        $firtLine= ['步骤编号', '步骤目标', '创建时间','备注','步骤类型','动作','内容'];
        $instructionRecord[]=$firtLine;
        for ($i = 0; $i < sizeof($instructionArray); $i++) {
          if(isset($instructionArray[$i])&&is_array($instructionArray[$i])){
                $otherLine=array();
                $instruction=$instructionArray[$i];
                if(isset($instruction['orderIndex'])){
                    $otherLine[]=$instruction['orderIndex'];
                }else{
                    $otherLine[]='';
                }
                if(isset($instruction['target'])){
                    $otherLine[]=$instruction['target'];
                }else{
                    $otherLine[]='';
                }
                if(isset($instruction['createdAt'])){
                    $otherLine[]=$instruction['createdAt'];
                }else{
                    $otherLine[]='';
                }
                if(isset($instruction['comment'])){
                    $otherLine[]=$instruction['comment'];
                }else{
                    $otherLine[]='';
                }
                if(isset($instruction['type'])){
                    $otherLine[]=$instruction['type'];
                }else{
                    $otherLine[]='';
                }
                if(isset($instruction['action'])){
                    $otherLine[]=$instruction['action'];
                }else{
                    $otherLine[]='';
                }
                if(isset($instruction['input'])){
                    $otherLine[]=$instruction['input'];
                }else{
                    $otherLine[]='';
                }
                    $instructionRecord[]=$otherLine;
                }
          }
        return $instructionRecord;
    }

}
