<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBiRemarksAdd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('additional_files_from_bi', function (Blueprint $table) {
            $table->string('bi_add_rem');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('additional_files_from_bi', function (Blueprint $table) {
            $table->dropColumn('bi_add_rem');
        });
    }
}
