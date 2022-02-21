<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKioskLoanUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kiosk_loan_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type_of_loan')->nullable();
            $table->string('applicant_lname')->nullable();
            $table->string('applicant_fname')->nullable();
            $table->string('applicant_mname')->nullable();
            $table->string('applicant_suffix')->nullable();
            $table->string('personal_mobile_number')->nullable();
            $table->string('personal_email_address')->nullable();
            $table->string('home_landline_number')->nullable();
            $table->string('pre_unit_number_bld_st_subd_brgy')->nullable();
            $table->string('pre_city_municipality')->nullable();
            $table->string('pre_province')->nullable();
            $table->string('per_unit_number_bld_st_subd_brgy')->nullable();
            $table->string('per_city_municipality')->nullable();
            $table->string('per_province')->nullable();
            $table->string('work_email_address');
            $table->string('work_landline_number');
            $table->string('work_unit_number_bld_st_subd_brgy')->nullable();
            $table->string('work_city_municipality')->nullable();
            $table->string('work_province')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('gender')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('home_ownership')->nullable();
            $table->string('sss_gsis_number')->nullable();
            $table->string('tin_number')->nullable();
            $table->string('spouse_lname')->nullable();
            $table->string('spouse_fname')->nullable();
            $table->string('spouse_mname')->nullable();
            $table->string('spouse_suffix')->nullable();
            $table->string('mothers_maiden_lname')->nullable();
            $table->string('mothers_maiden_fname')->nullable();
            $table->string('mothers_maiden_mname')->nullable();
            $table->string('source_of_income')->nullable();
            $table->string('employment_status')->nullable();
            $table->string('for_employed')->nullable();
            $table->string('for_self_employed')->nullable();
            $table->string('name_of_employer_business')->nullable();
            $table->string('job_title_position')->nullable();
            $table->string('nature_of_business')->nullable();
            $table->string('gross_annual_income')->nullable();
            $table->string('years_with_employer_in_business')->nullable();
            $table->string('months_with_employer_in_business')->nullable();
            $table->string('loan_extra_col_1')->nullable();
            $table->string('loan_extra_col_2')->nullable();
            $table->string('loan_extra_col_3')->nullable();
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
        Schema::dropIfExists('kiosk_loan_users');
    }
}
