<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('user_name');
            $table->string('posistion');
            $table->string('branch');
            $table->text('message');
            $table->string('pix_path');
            $table->string('date');
            $table->string('time');
            $table->string('user_level');
            $table->integer('count');
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
        Schema::drop('chat_messages');
    }
}
