<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('card_types', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('type_name');//联通 电信 移动
        //     $table->string('type_isp'); //10000
        //     $table->string('stop_sale')->default(0);//是否停售
        //     $table->timestamps();
        // });

        Schema::create('card_cases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('case_name');//卡种名称
            $table->string('case_icon');//卡种图标
            $table->text('text_short_desc')->nullable();//卡种文字介绍
            $table->longText('desc_top_imgs')->nullable();//卡种顶部图片组
            $table->longText('desc_bottom_imgs')->nullable();//卡种低部图片组
            $table->string('is_show_cards')->default(1);//是否显示套餐列表
            $table->string('stop_sale')->default(0);
            $table->string('stop_sale_tips')->nullable();
            $table->string('user_can_sale')->default(1); //是否允许用户销售
            $table->string('best_show')->default(1); //是否出现在精品
            $table->string('scan_show')->default(1); //是否出现在扫描
            $table->longText('case_other_datas')->nullable(); //其他配置信息（json格式）像特定地区才能申请的话可以放在这个里边
            $table->timestamps();
        });

        Schema::create('cards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('card_name');
            $table->string('card_icon');//卡种图标
            $table->text('card_item_img')->nullable();//套餐的卡片图片
            $table->string('card_product_id')->nullable();//第三方标识
            $table->string('card_product_type')->nullable();//第三方标识
            $table->string('first_month_fee')->nullable();//首月资费 A000011V000001
            $table->string('is_hot')->default(0);//是否推荐
            $table->text('text_short_desc')->nullable();//卡种问题介绍
            $table->text('img_short_desc')->nullable();//卡种图片介绍（单图片）tariffMethod
            $table->string('stop_sale')->default(0);
            $table->string('stop_sale_tips')->nullable();
            $table->string('user_can_sale')->default(1);// 是否允许用户销售
            $table->longText('card_other_datas')->nullable(); //其他配置信息（json格式）像特定地区才能申请，tariffMethod可以放在这个里边
            $table->unsignedInteger('card_case_id');
            $table->timestamps();
            $table->foreign('card_case_id')->references('id')->on('card_cases')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
        Schema::dropIfExists('card_cases');
    }
}
