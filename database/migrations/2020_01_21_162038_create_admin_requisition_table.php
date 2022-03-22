<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminRequisitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_requisition', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('req_reason');
            $table->text('req_reason_remarks');
            $table->date('date_request');
            $table->string('requestor_name');
            $table->string('office_loc_dep_pos');
            $table->date('date_needed');
            $table->string('approved_by');
            $table->date('approval_date');
            $table->string('other_check_0');
            $table->string('other_check_1');
            $table->string('other_check_2');
            $table->string('items_grand_total');
            $table->string('request_status');
            $table->text('approver_remarks');
            $table->string('admin_approver_id');
            $table->dateTime('date_time_approved');
            $table->datetime('date_time_denied');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_requisition');
    }
}
