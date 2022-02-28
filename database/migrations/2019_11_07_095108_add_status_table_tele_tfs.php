<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusTableTeleTfs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cc_bank_tele_save', function (Blueprint $table) {
            $table->string('status_click_encode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cc_bank_tele_save', function (Blueprint $table) {
            $table->dropColumn('status_click_encode');
        });
    }
}
