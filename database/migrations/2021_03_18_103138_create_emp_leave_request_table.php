<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpLeaveRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_leave_request', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('approver_id');
            $table->string('leave_type');
            $table->text('leave_reason');
            $table->date('leave_start');
            $table->date('leave_end');
            $table->string('leave_status');
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
        Schema::dropIfExists('emp_leave_request');
    }
}
