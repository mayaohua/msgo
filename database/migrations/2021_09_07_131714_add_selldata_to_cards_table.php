<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSelldataToCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('card_cases', function (Blueprint $table) {
            $table->text('sell_factor')->nullable(); //分销完成条件
            $table->text('sell_info')->nullable(); //分销佣金说明
            $table->string('sell_price')->nullable(); //分销价格说明
            $table->string('sell_banner_img')->nullable(); //分销海报图片
            $table->string('sell_item_img')->nullable(); //分销展示图片
        });

        Schema::table('cards', function (Blueprint $table) {
            $table->string('sell_price')->default(0); //分销价格说明
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('card_cases', function (Blueprint $table) {
            $table->dropColumn('sell_factor');
            $table->dropColumn('sell_info');
            $table->dropColumn('sell_price');
            $table->dropColumn('sell_banner_img');
            $table->dropColumn('sell_item_img');
        });
        Schema::table('cards', function (Blueprint $table) {
            $table->dropColumn('sell_price');
        });
    }
}