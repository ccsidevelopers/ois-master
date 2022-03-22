<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLeaveRemarksToViewLeaveRequestLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('view_leave_request_logs', function (Blueprint $table) {
            $table->string('leave_remarks')->after('leave_request_activity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('view_leave_request_logs', function (Blueprint $table) {
            $table->dropColumn('leave_remarks');
        });
    }
}
