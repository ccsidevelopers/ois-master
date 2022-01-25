<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemarksSoiEvrCcBank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cc_bank_evr_soi', function (Blueprint $table) {
            $table->text('soi_remarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cc_bank_evr_soi', function (Blueprint $table) {
            $table->dropColumn('soi_remarks');
        });
    }
}
