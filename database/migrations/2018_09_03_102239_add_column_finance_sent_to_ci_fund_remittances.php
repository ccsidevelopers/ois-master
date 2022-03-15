<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnFinanceSentToCiFundRemittances extends Migration
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
            $table->string('finance_sent',20)->after('id');

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

            $table->dropColumn('finance_sent');

        });
    }
}
