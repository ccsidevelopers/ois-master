<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditReportFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_report_form', function (Blueprint $table) {
            $table->increments('id');
            $table->string('audit_log_id');
            $table->integer('user_id');
            $table->string('client_name');
            $table->string('company_name');
            $table->string('busi_name');
            $table->string('busi_address');
            $table->string('type_of_request');
            $table->date('endorsement_date');
            $table->date('submission_date');
            $table->string('internal_tat');
            $table->string('external_tat');
            $table->string('special_instruction');
            $table->string('type_of_checking');
            $table->string('l_name');
            $table->string('f_name');
            $table->string('emp_id');
            $table->string('department');
            $table->string('job_title');
            $table->string('date_hired');
            $table->text('findings');
            $table->text('investigation');
            $table->text('valid_res');
            $table->text('statements');
            $table->text('observations');
            $table->text('recom');
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
        Schema::dropIfExists('audit_report_form');
    }
}
