<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdCheckingGroupToBiReturnCheckingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bi_return_checkings', function (Blueprint $table) {
            $table->string('id_checking_group')->after('id');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bi_return_checkings', function (Blueprint $table) {
            $table->dropColumn('id_checking_group');
        });
    }
}
