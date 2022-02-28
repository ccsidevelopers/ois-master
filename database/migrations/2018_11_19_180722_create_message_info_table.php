<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_info', function (Blueprint $table) {
            $table->increments('id');
            $table->text('message');
            $table->integer('from_user_id');
            $table->integer('to_user_id');
            $table->string('view',50);
            $table->string('all',50);
            $table->dateTime('date_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message_info');
    }
}
