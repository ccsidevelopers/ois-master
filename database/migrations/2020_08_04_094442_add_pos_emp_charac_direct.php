<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPosEmpCharacDirect extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bi_direct_applicant_character', function (Blueprint $table) {
           $table->string('charac_position')->after('charac_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bi_direct_applicant_character', function (Blueprint $table) {
            $table->dropColumn('charac_position');
        });
    }
}
