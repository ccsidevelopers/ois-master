<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToCiAtmFundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ci_atm_fund', function (Blueprint $table) {
            $table->dateTime('date_of_send')->after('amount');
            $table->string('receive_status',50)->after('amount');
            $table->dateTime('receive_status_date_time')->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ci_atm_fund', function ($table) {
            $table->dropColumn('date_of_send');
            $table->dropColumn('receive_status');
            $table->dropColumn('receive_status_date_time');
        });
    }
}
