<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOccupationParentsDirect extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bi_direct_applicant_endorsement', function (Blueprint $table) {
            $table->string('direct_father_occupation');
            $table->string('direct_mother_occupation');
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
            $table->dropColumn('direct_father_occupation');
            $table->dropColumn('direct_mother_occupation');
        });
    }
}
