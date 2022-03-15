<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFinanceLiqRemAfterAuditRemarksToFundRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fund_requests', function (Blueprint $table) {
            $table->text('finance_liq_rem')->after('audit_remarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fund_requests', function (Blueprint $table) {
            $table->dropColumn('finance_liq_rem');
        });
    }
}
