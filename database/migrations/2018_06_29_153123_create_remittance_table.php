<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemittanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remittance', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fund_id');;
            $table->string('receiver',50);
            $table->string('sender',50);
            $table->string('code',50);
            $table->string('amount',50);
            $table->text('remarks');
            $table->dateTime('date_of_send');
            $table->string('attachment_status',50);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('remittance');
    }
}
