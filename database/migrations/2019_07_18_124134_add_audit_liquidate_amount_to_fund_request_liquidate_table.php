<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAuditLiquidateAmountToFundRequestLiquidateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fund_request_liquidate', function (Blueprint $table) {
            $table->integer('audit_liquidate_amount')->after('liquidate_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fund_request_liquidate', function (Blueprint $table) {
            $table->dropColumn('audit_liquidate_amount');
        });
    }
}
