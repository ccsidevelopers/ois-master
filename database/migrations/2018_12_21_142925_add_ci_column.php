<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCiColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_profile', function (Blueprint $table) {
            $table->string('emp_no_days');
            $table->string('ci_area_muni');
            $table->string('ci_area_prov');
            $table->string('commuter_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_profile', function (Blueprint $table) {
            $table->dropColumn('emp_no_days');
            $table->dropColumn('ci_area_muni');
            $table->dropColumn('ci_area_prov');
            $table->dropColumn('commuter_type');
        });
    }
}
