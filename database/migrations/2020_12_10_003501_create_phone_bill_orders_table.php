<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhoneBillOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone_bill_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bill_mobile');//充值手机号
            $table->text('bill_type_name');//充值类型名称
            $table->string('bill_money');//充值金额
            $table->text('bill_type_text');//充值文本
            $table->string('bill_user_openid');//充值用户ID
            $table->longText('bill_user_data');//充值用户资料
            $table->string('bill_app_order_id')->unique();//我方流水号
            $table->string('bill_biz_order_id')->nullable();//平台方流水号
            $table->string('bill_wx_order_id')->nullable();//微信订单号
            $table->string('apply_from')->default('official');//订单来源
            $table->longText('bill_data');//充值信息
            $table->integer('bill_status')->default(0);//充值状态
            $table->text('bill_msg')->nullable();//失败信息
            //0 微信端未支付
            //1 微信端支付成功
            //2 微信端支付失败   //订单完成
            //3 平台方充值成功   //订单完成
            //4 平台方充值失败   //订单完成
            //5 平台方充值中     
            //6 退款中      
            //7 退款完成        //订单完成
            //8 退款失败        //订单完成
            //9 异常订单        //订单完成
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('finished_at')->nullable();//订单完成时间
        });

        Schema::create('phone_bill_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status_name');
            $table->text('status_desc')->nullable();
            $table->integer('status_id')->default(0);
            $table->timestamps();
            $table->unsignedInteger('phone_bill_order_id');
            $table->foreign('phone_bill_order_id')->references('id')->on('phone_bill_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phone_bill_status');
        Schema::dropIfExists('phone_bill_orders');
    }
}
