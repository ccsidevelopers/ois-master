<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCiAndAoInternalStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('endorsements',function (Blueprint $table)
        {
            $table->dateTime('ci_internal_status')->after('type_of_sending_report');
            $table->dateTime('ao_internal_status')->after('endorsement_status_internal');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('endorsement', function ($table) {

            $table->dropColumn('ci_internal_status');
            $table->dropColumn('ao_internal_status');

        });
    }
}
