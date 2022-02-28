<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmpStatusTagging extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_profile', function (Blueprint $table) {
            $table->string('emp_status_tagging')->after('contract_file_path');
            $table->string('incomplete_remarks')->after('emp_status_tagging');
            $table->string('return_remarks')->after('incomplete_remarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_profile', function (Blueprint $table) {
            $table->dropColumn('emp_status_tagging');
            $table->dropColumn('incomplete_remarks');
            $table->dropColumn('return_remarks');
        });
    }
}
