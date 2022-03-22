<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTemplateIdToCiSaveDataEncodedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ci_save_data_encoded', function (Blueprint $table) {
            $table->integer('temp_id')->after('ci_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ci_save_data_encoded', function (Blueprint $table) {
            $table->dropColumn('temp_id');
        });
    }
}
