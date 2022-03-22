<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDaysOfLeaveToEmpLeaveRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('emp_leave_request', function (Blueprint $table) {
            $table->integer('days_of_leave')->after('leave_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('emp_leave_request', function (Blueprint $table) {
            $table->dropColumn('days_of_leave');
        });
    }
}
