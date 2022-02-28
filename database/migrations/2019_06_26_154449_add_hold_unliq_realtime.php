<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHoldUnliqRealtime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ci_fund_realtime_amount', function (Blueprint $table) {
           $table->integer('hold_fund');
           $table->integer('unliq_fund');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ci_fund_realtime_amount', function (Blueprint $table) {
            $table->dropColumn('hold_fund');
            $table->dropColumn('unliq_fund');
        });
    }
}
