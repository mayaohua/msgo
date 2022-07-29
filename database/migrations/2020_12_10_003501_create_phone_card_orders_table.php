<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhoneCardOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone_card_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mobile');//下单号码
            $table->text('mobile_location');//归属地
            $table->text('card_name');//下单卡种
            $table->string('card_product_id');//产品goodsID
            $table->string('user_name');//下单人
            $table->text('user_code');//下单人身份证号码
            $table->string('user_phone');//下单人手机号
            $table->longText('user_address');//下单人地址
            $table->string('apply_from')->default('web');//订单来源   web,official,wxapp
            $table->string('order_to')->default('lt');//下单渠道   lt,gd
            $table->longText('user_data');//用户信息
            $table->longText('number_data');//号码信息
            $table->longText('card_data');//卡信息
            $table->longText('apply_data');//申请返回信息
            $table->string('card_status')->default('');//状态码
            //0 下单成功        
            //1 下单失败        //订单完成
            $table->text('card_msg')->default('');//失败信息
            $table->timestamps();//时间
            $table->softDeletes();
            $table->timestamp('finished_at')->nullable();//订单完成时间
        });

        Schema::create('phone_card_status', function (Blueprint $table) {//卡的状态
            $table->increments('id');
            $table->string('status_name');
            $table->text('status_desc')->nullable();
            $table->integer('status_id')->default(0);
            $table->timestamps();
            $table->unsignedInteger('phone_card_order_id');
            $table->foreign('phone_card_order_id')->references('id')->on('phone_card_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phone_card_status');
        Schema::dropIfExists('phone_card_orders');
    }
}
