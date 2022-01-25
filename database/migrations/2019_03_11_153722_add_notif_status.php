<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotifStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bi_account_to_users', function (Blueprint $table) {
            $table->integer('return_stat');
            $table->integer('finished_stat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bi_account_to_users', function (Blueprint $table) {
            $table->dropColumn('return_stat');
            $table->dropColumn('finished_stat');
        });
    }
}
