<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSaoToTeleFile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bi_endorsements', function (Blueprint $table) {
            $table->string('sao_to_tele_file_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bi_endorsements', function (Blueprint $table) {
            $table->dropColumn('sao_to_tele_file_path');
        });
    }
}
