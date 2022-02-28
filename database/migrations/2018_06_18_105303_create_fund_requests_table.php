<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFundRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_requests', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('dispatcher_id');
            $table->integer('ci_id');
            $table->integer('sao_id');
            $table->integer('finance_id');

            $table->string('fund_amount');
            $table->dateTime('dispatcher_request_date');
            $table->dateTime('sao_approved_date');
            $table->dateTime('finance_approved_date');
            $table->dateTime('delivered_date');

            $table->text('dispatcher_remarks');
            $table->text('sao_remarks');
            $table->text('finance_remarks');
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
        Schema::drop('fund_requests');
    }
}
