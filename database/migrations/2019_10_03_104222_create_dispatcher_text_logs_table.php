<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDispatcherTextLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispatcher_text_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('ci_id');
            $table->string('contact_number');
            $table->string('char_count');
            $table->string('message_sent');
            $table->string('status');
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
        Schema::dropIfExists('dispatcher_text_logs');
    }
}
