<?php

namespace App\Http\Controllers\Pay;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Yansongda\Pay\Pay;

class AliPayController extends Controller
{


	public function alipay(Request $request){

	    $config = [
	    'app_id' => env("ALI_APP_ID",""),
	    //'notify_url' => env("app_id",""),
	    //'return_url' => env("app_id",""),
	    'ali_public_key' => env("ALI_PUBLIC_KEY",""),
	    'private_key' => env("ALI_PRIVATE_KEY",""),	//optional,设置此参数，将进入沙箱模式
	    'mode' => env("MODE",""),
		];

        //$config['return_url'] = $config['return_url'].'?id='.$request->id;

        //$config['notify_url'] = $config['notify_url'].'?id='.$request->id;

        $total_amount = '2';

        $subject = 'meowlomo_ATM_';
		// 支付
		$order = [
		    'out_trade_no' => time(),
		    'total_amount' => $total_amount,
		    'subject' => $subject,
		];

		$alipay = Pay::alipay($config)->web($order);

		return $alipay;
		}


	public function aliPayRefund(Request $request){
        try {
            $payOrder = [
                'out_trade_no' => $request->out_trade_no, // 商家订单号
                'refund_amount' => $request->total_amount, // 退款金额  不得超过该订单总金额
                'out_request_no' => Str::getUuid() // 同一笔交易多次退款标识（部分退款标识）
            ];

            $config = config('alipay.pay');

            // 返回状态码 code 10000 成功
            $result = Pay::alipay($config)->refund($payOrder);
            if (empty($result->code) || $result->code !== '10000') throw new \Exception('请求支付宝退款接口失败');
            // 订单改为 已退款状态
            // ~~自己商城的订单状态修改逻辑
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return false;
        }
    }

    public function notify()
    {
    	$config = config('alipay.pay');
        $alipay = Pay::alipay($config);
    
        try{
            $data = $alipay->verify(); // 是的，验签就这么简单！

            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况

            Log::debug('Alipay notify', $data->all());
        } catch (\Exception $e) {
            // $e->getMessage();
        }

        return $alipay->success()->send();// laravel 框架中请直接 `return $alipay->success()`
    }


}
