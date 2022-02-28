<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLogsCiExpenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ci_logs_expenses', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('activity_id');
            $table->text('activity');
            $table->string('type',100);
            $table->dateTime('datetime');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ci_logs_expenses');
    }
}
