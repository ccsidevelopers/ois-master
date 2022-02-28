<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatTableCiShellIncludeFund extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ci_shell_include_fund', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fund_id');
            $table->integer('shell_id');
            $table->string('with_or_without',100);
            $table->dateTime('receive_status_date_time');
            $table->string('receive_status',100);
            $table->dateTime('date_of_send');
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
        Schema::dropIfExists('ci_shell_include_fund');
    }
}
