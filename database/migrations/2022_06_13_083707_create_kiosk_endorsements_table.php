<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKioskEndorsementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kiosk_endorsements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('applicant_lname');
            $table->string('applicant_fname');
            $table->string('applicant_mname');
            $table->string('applicant_suffix');
            $table->string('personal_mobile_number');
            $table->string('personal_email_address');
            $table->string('home_landline_number');
            $table->string('work_email_address');
            $table->string('work_landline_number');
            $table->string('birth_date');
            $table->string('birth_place');
            $table->string('citizenship');
            $table->string('gender');
            $table->string('civil_status');
            $table->string('home_ownership');
            $table->string('sss_gsis_number');
            $table->string('tin_number');
            $table->string('spouse_lname');
            $table->string('spouse_fname');
            $table->string('spouse_mname');
            $table->string('spouse_suffix');
            $table->string('mothers_maiden_lname');
            $table->string('mothers_maiden_fname');
            $table->string('mothers_maiden_mname');
            $table->string('source_of_income');
            $table->string('employment_status');
            $table->string('for_employed');
            $table->string('for_self_employed');
            $table->string('name_of_employer_business');
            $table->string('job_title_position');
            $table->string('nature_of_business');
            $table->string('gross_annual_income');
            $table->string('years_with_employer_in_business');
            $table->string('months_with_employer_in_business');
            $table->string('uploaded_file_path');
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
        Schema::dropIfExists('kiosk_endorsements');
    }
}
