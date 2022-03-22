<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIssuanceDraftsSender extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_issuance_drafts', function (Blueprint $table) {
            $table->string('issuance_sender');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_issuance_drafts', function (Blueprint $table) {
            $$table->dropColumn('issuance_sender');
        });
    }
}
