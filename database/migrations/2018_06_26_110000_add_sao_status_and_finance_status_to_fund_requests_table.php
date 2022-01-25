<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSaoStatusAndFinanceStatusToFundRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fund_requests', function (Blueprint $table) {
            $table->string('dispatcher_status')->after('finance_remarks');
            $table->string('sao_status')->after('dispatcher_status');
            $table->string('finance_status')->after('sao_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fund_requests', function ($table) {
            $table->dropColumn('dispatcher_status');
            $table->dropColumn('sao_status');
            $table->dropColumn('finance_status');
        });
    }
}
