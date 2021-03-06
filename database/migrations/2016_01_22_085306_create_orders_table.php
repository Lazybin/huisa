<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('out_trade_no');//订单号
            $table->string('consignee');//收货人
            $table->string('shipping_address');//收货地址
            $table->string('mobile');//收货人电话
            $table->double('total_fee');//付款金额
            $table->double('shipping_fee')->nullable();//总运费
            $table->tinyInteger('status');//订单状态 0---》待支付，1--》已支付，代发货，2--》取消，3-->已发货，4---》客户已签收，交易完成，5--->待发货申请退款，6----》已发货申请退款，7--->退款完成
            $table->timestamp('shipments_time')->nullable();//发货时间
            $table->string('express_company_name')->nullable();//快递公司名称
            $table->string('express_number')->nullable();//快递号
            $table->timestamp('payment_time');//支付时间
            $table->tinyInteger('payment_way');//支付方式 1--》支付宝，2--》微信，3--》银联
            $table->tinyInteger('is_remind');//是否提醒发货，0---》否，1---》是

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
