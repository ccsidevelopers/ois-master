<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFilePathToAuditCiReportCheckingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audit_ci_report_checking', function (Blueprint $table) {
            $table->text('file_path')->after('cause_of_delay');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audit_ci_report_checking', function (Blueprint $table) {
            $table->dropColumn('file_path');
        });
    }
}
