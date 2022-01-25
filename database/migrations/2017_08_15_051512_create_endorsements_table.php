<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateEndorsementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('endorsements', function (Blueprint $table) {
            $table->increments('id');

            $table->date('date_endorsed');
            $table->time('time_endorsed');

            $table->date('date_due');
            $table->time('time_due');

            $table->string('account_name',150);
            $table->text('address',100);
            $table->string('city_muni',50);
            $table->string('provinces',50);
            $table->string('business_name',100);
            $table->string('employer_name',100);
            $table->string('client_name',100);
            $table->string('requestor_name',100);
            $table->string('type_of_loan',20);
            $table->string('type_of_request',20);
            $table->string('type_of_sending_report',10);

            $table->string('endorsement_status_internal',10);
            $table->string('endorsement_status_external',10);
            $table->string('picture_status',10);
            $table->string('verify_through',15);
            $table->string('handled_by_dispatcher',150);
            $table->string('assigned_by_srao',150);
            $table->string('handled_by_account_officer',140);
            $table->string('handled_by_credit_investigator',140);
            $table->string('acct_status',2);
            $table->string('acct_branch', 20);
            $table->text('remarks');
            $table->text('client_remarks');
            $table->string('prioritize');
            $table->string('add_verification');

            $table->date('date_dispatched');
            $table->time('time_dispatched');

            $table->date('date_srao_assigned');
            $table->time('time_srao_assigned');

            $table->date('date_ci_visit');
            $table->time('time_ci_visit');

            $table->date('date_ci_forwarded');
            $table->time('time_ci_forwarded');

            $table->date('date_ao_download');
            $table->time('time_ao_download');

            $table->date('date_forwarded_to_client');
            $table->time('time_forwarded_to_client');

            $table->string('rate');
            $table->string('re_ci');
            $table->string('bill');
            $table->string('ci_cert');
            $table->string('appliedrule');

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
        Schema::drop('endorsements');
    }
}
