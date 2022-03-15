<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVerifyTeleStatusDetailsToBiEndorsementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bi_endorsements', function (Blueprint $table) {
            $table->string('verify_tele_status_details')->after('verify_tele_status');
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
            $table->dropColumn('verify_tele_status_details');
        });
    }
}
