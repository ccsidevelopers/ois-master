<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReportLogIdToCcTeleEncodedData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cc_tele_encoded_data', function (Blueprint $table) {
            $table->string('report_log_id')->after('id');
            $table->string('checking_name')->after('checking_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cc_tele_encoded_data', function (Blueprint $table) {
            $table->dropColumn('report_log_id');
            $table->dropColumn('checking_name');
        });
    }
}
