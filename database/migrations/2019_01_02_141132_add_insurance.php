<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInsurance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_atm', function (Blueprint $table) {
            $table->string('emp_health_card');
            $table->string('emp_accident');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_atm', function (Blueprint $table) {
            $table->dropColumn('emp_health_card');
            $table->dropColumn('emp_accident');
        });
    }
}
