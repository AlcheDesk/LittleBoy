<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Services\ATM\TestCaseService;
use App\Mappers\ATM\TestCaseMapper;

class TestCaseSheet implements WithTitle, FromArray, ShouldAutoSize
{
    private $testCaseObj;
    private $testCaseService;
    private $testCaseMapper;

    public function __construct($testCaseObj)
    {
        $this->testCaseObj  = $testCaseObj;
        $this->testCaseService = new TestCaseService();
        $this->testCaseMapper = new TestCaseMapper();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        // Maximum 31 characters allowed in sheet title
        $title = $this->testCaseObj['name'];
        if(mb_strlen($title,"utf-8")>29){
            $title = mb_substr($this->testCaseObj['name'] , 0 , 29, 'utf-8').'_'.rand(0, 9);
        }
        return  $title;
    }

    public function array(): array
    {
        $instructionArray = $this->testCaseObj['instructions'];
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
