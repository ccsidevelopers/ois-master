<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserAgentAndFirstReportSentToAttendanceAllEmployee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendance_all_employee', function (Blueprint $table) {
            $table->string('user_agent')->after('ip_address');
            $table->dateTime('first_report_sent')->after('user_agent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendance_all_employee', function (Blueprint $table) {
            $table->dropColumn('user_agent');
            $table->dropColumn('first_report_sent');
        });
    }
}
