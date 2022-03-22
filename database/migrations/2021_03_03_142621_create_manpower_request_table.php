<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManpowerRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manpower_request', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('requestor_id');
            $table->integer('approver_id');
            $table->string('off_loc_dept_pos');
            $table->string('reason_vacancy_cb');
            $table->string('cb_data');
            $table->text('reason_remarks');
            $table->string('job_details_loc_dept_pos');
            $table->integer('no_of_candidates');
            $table->string('qualification');
            $table->string('job_offer_salary');
            $table->string('equipment_request');
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
        Schema::dropIfExists('manpower_request');
    }
}
