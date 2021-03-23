<?php
/**
 * Created by PhpStorm.
 * User: liu
 * Date: 2018/4/16
 * Time: 16:19
 */
namespace App\Http\Controllers\Test;

use App\Services\ATM\InstructionResultService;
use App\Services\ATM\TestCaseService;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Mustache_Engine;

class PdfTestController
{

    private $baseService;

    public function __construct()
    {
        $this->testCaseMapper = new TestCaseService();
        $this->instructionResultMapper = new InstructionResultService();
    }

    public function testDownloadPdf(Request $request)
    {
        $stepLogArray = $this->instructionResultMapper->getStepLogsByInstructionResultId($this->instructionResultMapper->parse_query($request->getQueryString()), 34147);
        $data = "";
        for ($x = 0; $x < count($stepLogArray['data']); $x ++) {
            $data = $data . $stepLogArray['data'][0]['message'] . "\n";
        }
        $template = '<html>
<head>
<title>show</title>
        <style>
            @font-face {
                font-family: msyh;
                font-style: normal;
                font-weight: normal;
                src: url(fonts/msyh.ttf) format(truetype);
            }
            html, body {  height: 100%;  }
            body {  margin: 0;  padding: 0;  width: 100%;
                /*display: table;  */
                font-weight: 100;  font-family: msyh;  }
            .container {  text-align: center;
                /*display: table-cell; */
                vertical-align: middle;  }
            .content {  text-align: center;  display: inline-block;  }
            .title {  font-size: 96px;  }
        </style>
<head>
<body>
{{planet}}
</body>
</html>';
        $m = new Mustache_Engine();
        $s = $m->render($template, array(
            'planet' => $data
        ));
        $pdf = PDF::loadHTML($s);
        return $pdf->download('invoice.pdf');
    }

    /**
     * 测试web页面展示pdf，使用loadHTML()方法加载
     *
     * @return mixed
     */
    public function testStreamPdf(Request $request)
    {
        $stepLogArray = $this->instructionResultMapper->getStepLogsByInstructionResultId($this->instructionResultMapper->parse_query($request->getQueryString()), 34147);
        $data = "";
        for ($x = 0; $x < count($stepLogArray['data']); $x ++) {
            $data = $data . $stepLogArray['data'][0]['message'] . "\n";
        }
        $template = '<html>
<head>
<title>show</title>
        <style>
            @font-face {
                font-family: msyh;
                font-style: normal;
                font-weight: normal;
                src: url(fonts/msyh.ttf) format(truetype);
            }
            html, body {  height: 100%;  }
            body {  margin: 0;  padding: 0;  width: 100%;
                /*display: table;  */
                font-weight: 100;  font-family: msyh;  }
            .container {  text-align: center;
                /*display: table-cell; */
                vertical-align: middle;  }
            .content {  text-align: center;  display: inline-block;  }
            .title {  font-size: 96px;  }
        </style>
<head>
<body>
{{planet}}
</body>
</html>';
        $m = new Mustache_Engine();
        $s = $m->render($template, array(
            'planet' => $data
        ));
        $pdf = PDF::loadHTML($s);
        return $pdf->stream();
    }
}