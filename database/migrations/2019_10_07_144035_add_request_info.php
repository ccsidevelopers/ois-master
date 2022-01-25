<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRequestInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_atm', function (Blueprint $table) {
            $table->string('fb_info');
            $table->string('computer_info');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_atm', function (Blueprint $table) {
            $table->dropColumn('fb_info');
            $table->dropColumn('computer_info');
        });
    }
}
