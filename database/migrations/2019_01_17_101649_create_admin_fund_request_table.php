<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminFundRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_fund_request', function (Blueprint $table) {
            $table->increments('id');
            $table->string('request_month');
            $table->string('request_branch');
            $table->string('request_amount');
            $table->string('request_particular');
            $table->string('request_account');
            $table->date('statement_date');
            $table->date('due_date');
            $table->date('date_requested');
            $table->string('requested_processed');
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
        Schema::dropIfExists('admin_fund_request');
    }
}
