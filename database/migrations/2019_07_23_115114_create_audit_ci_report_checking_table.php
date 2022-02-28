<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditCiReportCheckingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_ci_report_checking', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('emp_id');
            $table->string('log_id');
            $table->string('emp_name');
            $table->date('date_hired');
            $table->string('ci_area');
            $table->string('ci_branch_head');
            $table->string('ci_regional_head');
            $table->string('ci_senior_account_officer');
            $table->string('ci_supervisor');
            $table->string('oims_endorse_id');
            $table->string('messenger_endorse_id');
            $table->string('account_name');
            $table->string('bank_name');
            $table->date('endorse_date');
            $table->date('date_visited');
            $table->string('account_tor');
            $table->string('handling_type');
            $table->string('account_source');
            $table->integer('completeness');
            $table->string('completeness_remarks');
            $table->integer('gps_attachment');
            $table->string('gps_attachment_remarks');
            $table->integer('informants_validity');
            $table->string('informants_validity_remarks');
            $table->integer('encoding_accuracy');
            $table->string('encoding_accuracy_remarks');
            $table->integer('selfie_uniform_id');
            $table->string('selfie_uniform_id_remarks');
            $table->integer('tat_compliance');
            $table->string('tat_compliance_remarks');
            $table->integer('attached_documents');
            $table->string('attached_documents_remarks');
            $table->integer('total_score');
            $table->string('report_summary');
            $table->string('cause_of_delay');
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
        Schema::dropIfExists('audit_ci_report_checking');
    }
}
