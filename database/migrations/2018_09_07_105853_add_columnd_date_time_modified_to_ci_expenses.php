<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumndDateTimeModifiedToCiExpenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ci_expenses',function (Blueprint $table)
        {
            $table->dateTime('date_time_modified')->after('shell_include');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ci_expenses', function ($table) {

            $table->dropColumn('date_time_modified');

        });
    }
}
