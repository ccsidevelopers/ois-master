<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBenefitsForDirect extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bi_direct_applicant_endorsement', function (Blueprint $table) {
            $table->string('direct_tin');
            $table->string('direct_philhealth');
            $table->string('direct_pagibig');
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
            $table->dropColumn('direct_tin');
            $table->dropColumn('direct_philhealth');
            $table->dropColumn('direct_pagibig');
        });
    }
}
