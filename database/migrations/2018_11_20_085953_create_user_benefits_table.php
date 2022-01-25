<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBenefitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_benefits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('emp_sss');
            $table->string('emp_philhealth');
            $table->string('emp_pagibig');
            $table->string('emp_tin');
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
        Schema::dropIfExists('user_benefits');
    }
}
