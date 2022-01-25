<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemarksIndiv extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fund_request_liquidate', function (Blueprint $table)
        {
            $table->string('indiv_remarks')->after('liquidate_amount');
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
            $table->dropColumn('indiv_remarks');
        });
    }
}
