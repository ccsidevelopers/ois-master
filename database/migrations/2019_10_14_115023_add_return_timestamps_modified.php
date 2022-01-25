<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReturnTimestampsModified extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audits_log', function (Blueprint $table) {
            $table->dateTime('return_date_time');
            $table->dateTime('last_modified_date_time');
            $table->integer('notif_stat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audits_log', function (Blueprint $table) {
            $table->dropColumn('return_date_time');
            $table->dropColumn('last_modified_date_time');
            $table->dropColumn('notif_stat');
        });
    }
}
