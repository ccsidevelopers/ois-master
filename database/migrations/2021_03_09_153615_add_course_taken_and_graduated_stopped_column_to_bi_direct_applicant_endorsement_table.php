<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCourseTakenAndGraduatedStoppedColumnToBiDirectApplicantEndorsementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bi_direct_applicant_endorsement', function (Blueprint $table) {
            $table->string('direct_course_taken')->after('direct_college_year_graduated');
            $table->string('direct_stopped_graduated_rem')->after('direct_course_taken');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bi_direct_applicant_endorsement', function (Blueprint $table) {
            $table->dropColumn('direct_course_taken');
            $table->dropColumn('direct_stopped_graduated_rem');
        });
    }
}
