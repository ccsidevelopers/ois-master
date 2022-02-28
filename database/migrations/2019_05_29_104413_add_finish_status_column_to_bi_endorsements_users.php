<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFinishStatusColumnToBiEndorsementsUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bi_endorsements_users', function (Blueprint $table) {
            $table->integer('finish_status')->after('position_id');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bi_endorsements_users', function (Blueprint $table) {
            $table->dropColumn('finish_status');
        });
    }
}
