<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBiIdToBiDirectEncodedData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bi_direct_encoded_data', function (Blueprint $table) {
            $table->string('bi_id')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bi_direct_encoded_data', function (Blueprint $table) {
            $table->dropColumn('bi_id');
        });
    }
}
