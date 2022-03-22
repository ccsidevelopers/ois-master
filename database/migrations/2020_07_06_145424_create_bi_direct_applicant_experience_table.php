<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiDirectApplicantExperienceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bi_direct_applicant_experience', function (Blueprint $table) {
            $table->increments('id');
            $table->string('direct_id');
            $table->date('date_started');
            $table->date('date_ended');
            $table->string('date_ended_present');
            $table->string('position');
            $table->string('emp_no');
            $table->text('emp_address');
            $table->string('emp_contact_no');
            $table->string('supervisor_name');
            $table->string('supervisor_number');
            $table->text('reason_leaving');
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
        Schema::dropIfExists('bi_direct_applicant_experience');
    }
}
