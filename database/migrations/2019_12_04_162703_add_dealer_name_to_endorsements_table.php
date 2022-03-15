<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDealerNameToEndorsementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('endorsements', function (Blueprint $table) {
            $table->string('dealer_name');
            $table->string('contract_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('endorsements', function (Blueprint $table) {
            $table->dropColumn('dealer_name');
            $table->dropColumn('contract_number');
        });
    }
}
