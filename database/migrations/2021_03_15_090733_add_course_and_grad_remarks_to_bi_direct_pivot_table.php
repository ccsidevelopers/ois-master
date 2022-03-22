<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCourseAndGradRemarksToBiDirectPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bi_direct_pivot', function (Blueprint $table) {
            $table->string('direct_course_taken')->after('endorse_id');
            $table->string('direct_stopped_graduated_rem')->after('endorse_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bi_direct_pivot', function (Blueprint $table) {
            $table->dropColumn('direct_course_taken');
            $table->dropColumn('direct_stopped_graduated_rem');
        });
    }
}
