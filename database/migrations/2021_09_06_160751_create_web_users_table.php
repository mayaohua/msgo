<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebUsersTable extends Migration
{
    public function up()
    {
        Schema::create('web_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_name');
            $table->string('user_code');
            $table->string('user_phone');
            $table->string('user_wx_id')->nullable();
            $table->integer('user_status')->default(1);//1为开通 2为禁用
            $table->string('user_openid')->unique();
            $table->string('user_key')->nullable();//用户的key
            $table->longText('user_info');
            $table->string('user_money')->default('0.00'); // 用户可提现金额
            $table->string('user_tixian_money')->default('0.00'); // 用户已提现金额
            $table->string('user_dongjie_money')->default('0.00'); // 用户提现冻结金额
            $table->string('user_order_count')->default(0); // 用户分销订单数
            $table->timestamps();
        });
        
        //用户分销订单通知（分为话费和手机卡）
        Schema::create('user_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_type'); // card or bill
            $table->text('order_name');
            $table->string('order_uuid');//订单号
            $table->text('order_info'); 
            $table->string('order_money'); //佣金价格
            $table->integer('order_status')->default(1);//1为处理中   2为审核中  3为发放佣金  4为处理失败
            $table->text('fail_msg')->nullable();//失败原因
            $table->unsignedInteger('user_id');
            $table->string('order_id');
            $table->foreign('user_id')->references('id')->on('web_users')->onDelete('cascade');
            $table->timestamps();
        });

        //用户提现记录
        Schema::create('user_tixians', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tixian_money');//提现金额
            $table->string('tixian_status');// 1为打款中   2为提现成功  3为提现驳回
            $table->text('fail_msg')->nullable();//拒绝原因
            $table->text('tixian_info')->nullable();//提现备注
            $table->text('tixian_img')->nullable();//提现收款码
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('web_users')->onDelete('cascade');
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
        Schema::dropIfExists('user_tixians');
        Schema::dropIfExists('user_orders');
        Schema::dropIfExists('web_users');
    }
}
