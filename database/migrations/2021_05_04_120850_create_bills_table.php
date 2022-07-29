<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type_name');
            $table->string('type_isp');
            $table->string('type_where');//区分 话费，流量和卡劵
            $table->timestamps();
        });

        Schema::create('bill_cases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('case_name');
            $table->text('short_desc')->nullable();
            $table->longText('desc_content')->nullable();
            $table->string('isp');
            $table->string('stop_sale')->default(0);
            $table->string('stop_sale_tips')->nullable();
            $table->unsignedInteger('bill_type_id');
            $table->string('item_profit'); //商品进货折扣
            $table->string('user_can_sale')->default(1); //是否允许用户销售
            $table->timestamps();
            $table->foreign('bill_type_id')->references('id')->on('bill_types')->onDelete('cascade');
        });

        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id');
            $table->string('package');
            $table->string('is_hot')->default(0);
            $table->longText('order_tips')->nullable();
            $table->text('yh_tips')->nullable();
            $table->string('stop_sale')->default(0);
            $table->string('stop_sale_tips')->nullable();
            $table->string('itemId'); //商品ID
            $table->string('itemProfit')->default(-1); //商品进货折扣  如果为-1则取case里边设置的折扣
            $table->string('itemFacePrice'); //商品面值
            $table->string('app_profit')->default(-1); 
            $table->string('user_can_sale')->default(1);
            $table->string('user_profit')->default(-1);//用户销售利润比
            $table->string('user_app_profit')->default(-1);//用户销售平台利润比
            $table->unsignedInteger('bill_case_id');
            $table->timestamps();
            $table->foreign('bill_case_id')->references('id')->on('bill_cases')->onDelete('cascade');
        });
        Schema::create('bill_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('facePrice');
            $table->string('itemSalePrice');
            $table->string('itemFreePrice');
            $table->string('AppFreePrice');
            $table->string('ProfixFreePrice');
            $table->string('UserFreePrice');
            $table->string('UserAppFreePrice');
            $table->string('AppSalePrice');
            $table->string('UserSalePrice');
            $table->unsignedInteger('bill_id');
            $table->timestamps();
            $table->foreign('bill_id')->references('id')->on('bills')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bill_datas');
        Schema::dropIfExists('bills');
        Schema::dropIfExists('bill_cases');
        Schema::dropIfExists('bill_types');
    }
}
