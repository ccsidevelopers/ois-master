<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFixedRemarks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_sched', function (Blueprint $table) {
            $table->string('emp_fixed_sched');
            $table->string('emp_sched_remarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_sched', function (Blueprint $table) {
            $table->dropColumn('emp_fixed_sched');
            $table->dropColumn('emp_sched_remarks');

        });
    }
}
