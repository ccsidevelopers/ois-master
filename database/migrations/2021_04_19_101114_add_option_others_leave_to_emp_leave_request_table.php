<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOptionOthersLeaveToEmpLeaveRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('emp_leave_request', function (Blueprint $table) {
            $table->string('opt_others_leave')->after('days_of_leave');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('emp_leave_request', function (Blueprint $table) {
            $table->dropColumn('opt_others_leave');
        });
    }
}
