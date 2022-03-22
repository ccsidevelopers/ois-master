<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOutStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_requisition', function (Blueprint $table) {
            $table->string('out_status');
            $table->datetime('main_approver_date_approved');
            $table->string('main_approver_id');
            $table->text('main_approver_remarks');
            $table->datetime('main_approver_date_denied');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_requisition', function (Blueprint $table) {
            $table->dropColumn('out_status');
            $table->dropColumn('main_approver_date_approved');
            $table->dropColumn('main_approver_id');
            $table->dropColumn('main_approver_remarks');
            $table->dropColumn('main_approver_date_denied');
        });
    }
}
