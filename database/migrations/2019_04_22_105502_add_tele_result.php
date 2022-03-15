<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTeleResult extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bi_endorsements', function (Blueprint $table) {
            $table->string('verify_tele_status');
            $table->string('tele_report_file_to_sao_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bi_endorsements', function (Blueprint $table) {
            $table->dropColumn('verify_tele_status');
            $table->dropColumn('tele_report_file_to_sao_path');
        });
    }
}
