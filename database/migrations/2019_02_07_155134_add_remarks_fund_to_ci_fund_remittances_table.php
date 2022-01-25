<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemarksFundToCiFundRemittancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ci_fund_remittances', function (Blueprint $table) {
            $table->text('remarks_fund')->after('check');
            $table->dateTime('date_time_remarks')->after('remarks_fund');

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
            $table->dropColumn('remarks_fund');
            $table->dropColumn('date_time_remarks');
        });
    }
}
