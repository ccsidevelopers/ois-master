<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnShellCardRequestToFundRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('fund_requests', function (Blueprint $table) {
            $table->string('type_of_fund_request',50)->after('finance_status');
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
            $table->dropColumn('type_of_fund_request');
        });

    }
}
