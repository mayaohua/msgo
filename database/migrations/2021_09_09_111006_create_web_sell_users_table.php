<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebSellUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_sell_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_openid');
            $table->longText('user_info');
            $table->integer('sale_user_id')->default(0);
            $table->integer('order_count')->default(0);//订单数
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
        Schema::dropIfExists('web_sell_users');
    }
}
