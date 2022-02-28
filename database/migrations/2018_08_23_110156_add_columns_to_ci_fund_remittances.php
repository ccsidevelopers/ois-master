<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToCiFundRemittances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ci_fund_remittances', function (Blueprint $table) {
            $table->dateTime('remittance_send_date_time')->after('ci_atm_fund_id');
            $table->dateTime('shell_send_date_time')->after('remittance_send_date_time');
            $table->dateTime('atm_send_date_time')->after('shell_send_date_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ci_fund_remittances', function ($table) {
            $table->dropColumn('remittance_send_date_time');
            $table->dropColumn('shell_send_date_time');
            $table->dropColumn('atm_send_date_time');
        });
    }
}
