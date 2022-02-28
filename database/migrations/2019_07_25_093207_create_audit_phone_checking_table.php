<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditPhoneCheckingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_phone_checking', function (Blueprint $table) {
            $table->increments('id');
            $table->string('audit_log_id');
            $table->integer('oims_id');
            $table->string('subj_name');
            $table->string('busi_name');
            $table->string('subj_bus_name');
            $table->datetime('audit_logged');
            $table->string('auditor_name');
            $table->string('findings');
            $table->string('done_thru');
            $table->string('client_name');
            $table->string('type_of_request');
            $table->date('endorsement_date');
            $table->date('ci_date_visit');
            $table->string('spec_ins');
            $table->string('type_of_checking');
            $table->string('emp_name');
            $table->string('emp_id');
            $table->string('emp_dept');
            $table->string('emp_job');
            $table->string('emp_date_hired');
            $table->text('summary_report');
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
        Schema::dropIfExists('audit_phone_checking');
    }
}
