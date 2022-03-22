<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFundStatusToFundUtilityExpensesTableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fund_utility_expenses_table', function (Blueprint $table) {
            $table->string('fund_status')->after('branch');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fund_utility_expenses_table', function (Blueprint $table) {
            $table->dropColumn('fund_status');
        });
    }
}
