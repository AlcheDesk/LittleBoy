<?php
namespace App\Http\Controllers\API;

use App\Services\ATM\TestCaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Excel;

class ExportController
{

    private $baseService;

    public function __construct()
    {
        $this->baseService = new TestCaseService();
    }

    public function exportExcelByTestCaseId(Request $request, $testCaseId)
    {
        $data = array(
            array(
                'data1',
                'data2'
            ),
            array(
                'data3',
                'data4'
            )
        );
        // $testCases = $this->baseService->selectById($this->baseService->parse_query($request->getQueryString()), $testCaseId);
        $testCases = $this->baseService->selectById($request, $testCaseId);
        $instructionsArray = $this->baseService->getInstructionsByTestCaseId($this->baseService->parse_query('orderBy=orderIndex asc'), $testCaseId);
        // $instructionsArray = $this->baseService->getInstructionByTestCaseId($request, $testCaseId);
        Excel::create($testCases['data']['0']['name'], function ($excel) use ($data, $testCases, $instructionsArray) {
            $excel->sheet('instructions', function ($sheet) use ($data, $testCases, $instructionsArray) {
                $sheet->prependRow(1, array(
                    '步骤类型',
                    '所属模块/程序-所属模块/程序',
                    '用例标题/摘要/前置条件',
                    '步骤',
                    '预期'
                ));

                $sheet->setSize(array(
                    'A1' => array(
                        'width' => 30,
                        'height' => 20
                    )
                ));

                $instructionsTargetArray = array();
                for ($i = 0; $i < $instructionsArray['metadata']['count']; $i ++) {
                    $instructionCollect = new Collection();
                    if (array_key_exists('type', $instructionsArray['data'][$i])) {
                        $instructionCollect->put('type', $instructionsArray['data'][$i]['type']);
                    } else {
                        $instructionCollect->put('type', null);
                    }
                    if (array_key_exists('action', $instructionsArray['data'][$i])) {
                        $instructionCollect->put('action', $instructionsArray['data'][$i]['action']);
                    } else {
                        $instructionCollect->put('action', null);
                    }
                    if (array_key_exists('input', $instructionsArray['data'][$i])) {
                        $instructionCollect->put('input', $instructionsArray['data'][$i]['input']);
                    } else {
                        $instructionCollect->put('input', null);
                    }
                    if (array_key_exists('comment', $instructionsArray['data'][$i])) {
                        $instructionCollect->put('comment', $instructionsArray['data'][$i]['comment']);
                    } else {
                        $instructionCollect->put('comment', null);
                    }
                    $instructionsTargetArray[$i] = $instructionCollect;
                }

                for ($i = 0; $i < $instructionsArray['metadata']['count']; $i ++) {
                    $sheet->row($i + 2, array(
                        $instructionsTargetArray[$i]['type'],
                        $instructionsTargetArray[$i]['action'],
                        $instructionsTargetArray[$i]['input'],
                        $instructionsTargetArray[$i]['comment']
                    ));
                }
            });
        })->export('xls');
    }
}
