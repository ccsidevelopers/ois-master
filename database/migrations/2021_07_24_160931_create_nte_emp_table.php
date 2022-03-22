<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNteEmpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nte_emp', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nte_sender');
            $table->string('user_id');
            $table->string('emp_id');
            $table->string('emp_name');
            $table->string('emp_email');
            $table->string('emp_position');
            $table->string('nte_acknowledger');
            $table->string('nte_reason');
            $table->string('nte_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nte_emp');
    }
}
