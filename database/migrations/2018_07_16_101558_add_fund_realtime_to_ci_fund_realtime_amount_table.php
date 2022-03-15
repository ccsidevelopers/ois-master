<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFundRealtimeToCiFundRealtimeAmountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ci_fund_realtime_amount', function (Blueprint $table) {
            $table->string('fund_realtime',50)->after('fund');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ci_fund_realtime_amount', function ($table) {
            $table->dropColumn('fund_realtime');
        });
    }
}
