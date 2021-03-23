<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Services\ATM\RunService;
use App\Mappers\ATM\RunMapper;

class RunSheet implements WithTitle, FromArray, ShouldAutoSize
{
    private $runObj;
    private $runService;
    private $runMapper;

    public function __construct($runObj)
    {
        $this->runObj  = $runObj;
        $this->runService = new RunService();
        $this->runMapper = new RunMapper();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        // Maximum 31 characters allowed in sheet title
        $title = $this->runObj['name'];
        if(mb_strlen($title,"utf-8")>29){
            $title = mb_substr($this->runObj['name'] , 0 , 29, 'utf-8').'_'.rand(0, 9);
        }
        return  $title;
    }

    public function array(): array
    {
        $instructionResultArray = $this->runObj['instructionResults'];
        $firtLine= ['步骤编号','步骤目标', '动作', '创建时间','状态','类型','内容','备注'];
        $instructionResultRecord[]=$firtLine;
        for ($i = 0; $i < sizeof($instructionResultArray); $i++) {
          if(isset($instructionResultArray[$i])&&is_array($instructionResultArray[$i])){
                $otherLine=array();
                $instructionResult=$instructionResultArray[$i];
                if(isset($instructionResult['logicalOrderIndex'])){
                    $otherLine[]=$instructionResult['logicalOrderIndex'];
                }else{
                    $otherLine[]='';
                }
                if(isset($instructionResult['target'])){
                    $otherLine[]=$instructionResult['target'];
                }else{
                    $otherLine[]='';
                }
                if(isset($instructionResult['action'])){
                    $otherLine[]=$instructionResult['action'];
                }else{
                    $otherLine[]='';
                }
                if(isset($instructionResult['createdAt'])){
                    $otherLine[]=$instructionResult['createdAt'];
                }else{
                    $otherLine[]='';
                }
                if(isset($instructionResult['status'])){
                    $otherLine[]=$instructionResult['status'];
                }else{
                    $otherLine[]='';
                }
                if(isset($instructionResult['runType'])){
                    $otherLine[]=$instructionResult['runType'];
                }else{
                    $otherLine[]='';
                }
                if(isset($instructionResult['input'])){
                    $otherLine[]=$instructionResult['input'];
                }else{
                    $otherLine[]='';
                }
                if(isset($instructionResult['comment'])){
                    $otherLine[]=$instructionResult['comment'];
                }else{
                    $otherLine[]='';
                }
                $instructionResultRecord[]=$otherLine;
            }
          }
        return $instructionResultRecord;
    }

}
