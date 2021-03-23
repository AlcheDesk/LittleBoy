<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RunFirstSheet implements WithTitle, FromArray, ShouldAutoSize
{
    private $runArray;

    public function __construct($runArray)
    {
        $this->runArray  = $runArray;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return  'runs';
    }

    public function array(): array
    {
        $runArray=$this->runArray['runs'];
        $firtLine= ['run编号', '用例名称', '创建时间','备注','状态'];
        $runRecord[]=$firtLine;
        for ($i = 0; $i < sizeof($runArray); $i++) {
          if(isset($runArray[$i])&&is_array($runArray[$i])){
                    $otherLine=array();
                    $run=$runArray[$i];
                    if(isset($run['id'])){
                        $otherLine[]=$run['id'];
                    }else{
                        $otherLine[]='';
                    }
                    if(isset($run['name'])){
                        $otherLine[]=$run['name'];
                    }else{
                        $otherLine[]='';
                    }
                    if(isset($run['createdAt'])){
                        $otherLine[]=$run['createdAt'];
                    }else{
                        $otherLine[]='';
                    }
                    if(isset($run['comment'])){
                        $otherLine[]=$run['comment'];
                    }else{
                        $otherLine[]='';
                    }
                    if(isset($run['status'])){
                        $otherLine[]=$run['status'];
                    }else{
                        $otherLine[]='';
                    }
                    $runRecord[]=$otherLine;
                }
          }
        return $runRecord;
    }

}
