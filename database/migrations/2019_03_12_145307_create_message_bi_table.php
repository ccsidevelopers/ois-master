<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageBiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_notif_bi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('message');
            $table->string('endorse_id');
            $table->string('sao_ao_id');
            $table->string('account_type');
            $table->integer('notif');
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
        Schema::dropIfExists('message_notif_bi');
    }
}
