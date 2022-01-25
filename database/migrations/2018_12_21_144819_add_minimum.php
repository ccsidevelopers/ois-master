<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMinimum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_profile', function (Blueprint $table) {
            $table->string('emp_rate');
            $table->string('emp_wage');
            $table->string('emp_process_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_table', function (Blueprint $table) {
            $table->dropColumn('emp_rate');
            $table->dropColumn('emp_wage');
            $table->dropColumn('emp_process_status');
        });
    }
}
