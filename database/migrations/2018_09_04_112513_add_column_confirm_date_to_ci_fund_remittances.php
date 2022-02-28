<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnConfirmDateToCiFundRemittances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ci_fund_remittances',function (Blueprint $table)
        {
            $table->dateTime('confirm_date_time')->after('atm_send_date_time');

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

            $table->dropColumn('confirm_date_time');

        });
    }
}
