<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('item_category');
            $table->string('item_brand_model');
            $table->datetime('item_date_purchased');
            $table->string('item_amount');
            $table->string('item_color');
            $table->string('item_remarks');
            $table->string('item_photo_path');
            $table->string('item_status');
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
        Schema::dropIfExists('item_profile');
    }
}
