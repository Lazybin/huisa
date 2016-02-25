<?php

namespace App\Http\Controllers;
require_once "../vendor/weixin_sdk/WxNotifyDeal.php";
use App\Model\Order;
use App\Model\UseCouponRecords;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class NotifyController extends Controller
{
    //
    public function weixin(){

        $deal=new \WxNotifyDeal();
        $deal->Handle(false);
    }

    public function wxCallBack(Request $request){
        $out_trade_no=$request->input('out_trade_no');
        $key=$request->input('key');
        if(($out_trade_no==null||$key==null)&&$key!='qj7adNDy6AdHB7SD'){
            return ;
        }
        $order = Order::where('out_trade_no', $out_trade_no)->first();
        if ($order != null) {
            $order->status = 1;
            $time = date("Y-m-d H:i:s", time());
            $order->payment_time = $time;
            $order->payment_way=2;
            $order->save();

            $useCouponRecords=UseCouponRecords::where('order_id',$order->id)->first();
            $useCouponRecords->status=2;
            if($useCouponRecords!=null){
                //礼券金额
                $apiParam=[
                    'accessToken'=>$useCouponRecords->access_token,
                    'coupon'=>$useCouponRecords->coupon,
                    'orderId'=>$out_trade_no
                ];
                $res=$this->post('/zhmf/member/consumerCoupon/useCoupon',$apiParam);
                $res=json_decode($res);

                if($res->Code==0){
                    $useCouponRecords->status=1;
                }
            }
            $useCouponRecords->save();
            echo 'success';
        }
    }

    public function yinlian(){
        include_once '../vendor/yinlian_sdk/acp_service.php';
        if (isset ( $_POST ['signature'] )) {
            if(\AcpService::validate ( $_POST )&&($_POST['respCode'] == '00'||$_POST['respCode'] == 'A6')) {
                $order = Order::where('out_trade_no', $_POST ['orderId'])->first();
                if ($order != null) {
                    $order->status = 1;
                    $time = date("Y-m-d H:i:s", time());
                    $order->payment_time = $time;
                    $order->payment_way=3;
                    $order->save();

                    $useCouponRecords=UseCouponRecords::where('order_id',$order->id)->first();
                    $useCouponRecords->status=2;
                    if($useCouponRecords!=null){
                        //礼券金额
                        $apiParam=[
                            'accessToken'=>$useCouponRecords->access_token,
                            'coupon'=>$useCouponRecords->coupon,
                            'orderId'=>$_POST ['orderId']
                        ];
                        $res=$this->post('/zhmf/member/consumerCoupon/useCoupon',$apiParam);
                        $res=json_decode($res);

                        if($res->Code==0){
                            $useCouponRecords->status=1;
                        }
                    }
                    $useCouponRecords->save();
                    echo 'success';
                }
            }else{
                @header('HTTP/1.1 500 Internal Server Error');
            }
        } else {
            @header('HTTP/1.1 500 Internal Server Error');
        }
    }

}
