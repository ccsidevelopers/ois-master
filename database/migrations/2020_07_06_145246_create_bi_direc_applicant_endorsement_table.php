<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiDirecApplicantEndorsementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bi_direct_applicant_endorsement', function (Blueprint $table) {
            $table->increments('id');
            $table->string('direct_last_name');
            $table->string('direct_first_name');
            $table->string('direct_middle_name');
            $table->string('direct_suffix_name');
            $table->date('direct_birthdate');
            $table->integer('direct_age');
            $table->string('direct_gender');
            $table->string('direct_marital_status');
            $table->string('direct_maiden_last');
            $table->string('direct_maiden_first');
            $table->string('direct_maiden_middle');
            $table->string('direct_birth_place');
            $table->string('direct_religion');
            $table->string('direct_tel_cp');
            $table->string('direct_sss');
            $table->string('direct_present_muni');
            $table->string('direct_present_prov');
            $table->string('direct_present_address');
            $table->string('direct_perma_muni');
            $table->string('direct_perma_prov');
            $table->string('direct_perma_address');
            $table->string('direct_spouse_name');
            $table->string('direct_spouse_tel_cp');
            $table->string('direct_father_name');
            $table->string('direct_father_age');
            $table->string('direct_father_tel');
            $table->string('direct_mother_name');
            $table->string('direct_mother_age');
            $table->string('direct_mother_tel');
            $table->string('direct_secondary_school');
            $table->string('direct_secondary_location');
            $table->string('direct_secondary_inclusive');
            $table->string('direct_secondary_year_graduated');
            $table->string('direct_college_school');
            $table->string('direct_college_location');
            $table->string('direct_college_inclusive');
            $table->string('direct_college_year_graduated');
            $table->string('direct_other_schools');
            $table->string('direct_civil_service');
            $table->string('direct_dismissed');
            $table->string('direct_dismissed_reason');
            $table->string('direct_attach_1');
            $table->string('direct_attach_2');
            $table->string('direct_attach_3');
            $table->string('direct_attach_4');
            $table->string('direct_profile_pic');
            $table->string('generated_code');
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
        Schema::dropIfExists('bi_direct_applicant_endorsement');
    }
}
