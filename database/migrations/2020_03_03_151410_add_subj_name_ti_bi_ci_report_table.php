<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubjNameTiBiCiReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bi_ci_report', function (Blueprint $table) {
            $table->string('subj_name')->after('ci_id');
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
            $table->dropColumn('subj_name');
        });
    }
}
