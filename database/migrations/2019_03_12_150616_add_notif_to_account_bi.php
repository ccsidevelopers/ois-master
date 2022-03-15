<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotifToAccountBi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bi_account_to_users', function (Blueprint $table) {
            $table->integer('message_notif');
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
            $table->dropColumn('message_notif');
        });
    }
}
