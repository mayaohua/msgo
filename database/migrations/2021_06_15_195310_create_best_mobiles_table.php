<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBestMobilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('best_mobiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mobile_number');
            $table->string('provice_code');
            $table->string('city_code');
            $table->string('provice_name');
            $table->string('city_name');
            $table->string('card_name');
            $table->integer('card_id');
            $table->string('is_sell')->default(0);
            $table->longText('data')->nullable();
            $table->string('mobile_from')->default('dsf');//dg   lt
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
        Schema::dropIfExists('best_mobiles');
    }
}
