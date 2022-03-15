<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnEndorsementStatusInternal2ToEndorsementTable extends Migration
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
            $table->text('endorsement_status_internal_2')->after('endorsement_status_internal');

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

            $table->dropColumn('endorsement_status_internal_2');

        });
    }
}
