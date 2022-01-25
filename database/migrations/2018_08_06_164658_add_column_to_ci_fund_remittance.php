<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToCiFundRemittance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ci_fund_remittances', function (Blueprint $table) {
            $table->integer('ci_atm_fund_id')->after('remittance_id');
            $table->integer('ci_shell_card_id')->after('remittance_id');
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
            $table->dropColumn('ci_atm_fund_id');
            $table->dropColumn('ci_shell_card_id');
        });
    }
}
