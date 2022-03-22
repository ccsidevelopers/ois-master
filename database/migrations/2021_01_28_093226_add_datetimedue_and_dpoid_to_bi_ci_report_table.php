<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDatetimedueAndDpoidToBiCiReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bi_ci_report', function (Blueprint $table) {
            $table->dateTime('date_time_due')->after('ci_note');
            $table->string('dpo_id')->after('ci_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bi_ci_report', function (Blueprint $table) {
            $table->dropColumn('date_time_due');
            $table->dropColumn('dpo_id');
        });
    }
}
