<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_list', function (Blueprint $table) {
            $table->increments('id');
            $table->string('emp_id');
            $table->string('emp_name');
            $table->string('emp_job');
            $table->string('emp_dept');
            $table->date('emp_date_hired');
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
        Schema::dropIfExists('employee_list');
    }
}
