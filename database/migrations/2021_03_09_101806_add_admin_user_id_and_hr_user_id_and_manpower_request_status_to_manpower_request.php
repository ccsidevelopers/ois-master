<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminUserIdAndHrUserIdAndManpowerRequestStatusToManpowerRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manpower_request', function (Blueprint $table) {
            $table->string('hr_user_id');
            $table->string('admin_user_id');
            $table->string('manpower_request_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manpower_request', function (Blueprint $table) {
            $table->dropColumn('hr_user_id');
            $table->dropColumn('admin_user_id');
            $table->dropColumn('manpower_request_status');
        });
    }
}
