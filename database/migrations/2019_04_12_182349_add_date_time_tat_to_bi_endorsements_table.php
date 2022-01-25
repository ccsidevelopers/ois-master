<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateTimeTatToBiEndorsementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bi_endorsements', function (Blueprint $table) {

            $table->dateTime('date_time_approved');
            $table->dateTime('date_time_return');
            $table->dateTime('date_time_due');
            $table->string('type_of_tat',50);

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

            $table->dropColumn('date_time_approved');
            $table->dropColumn('date_time_return');
            $table->dropColumn('date_time_due');
            $table->dropColumn('type_of_tat');


        });
    }
}
