<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApplicationStatusToBiDirectPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bi_direct_pivot', function (Blueprint $table) {
            $table->String('application_status')->after('direct_status');
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
            $table->dropColumn('application_status');
        });
    }
}
