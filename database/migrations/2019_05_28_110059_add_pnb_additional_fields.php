<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPnbAdditionalFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bi_endorsements', function (Blueprint $table)
        {
            $table->string('type_of_endorsement_bank')->after('bi_id');
            $table->string('loan_type_bank');
            $table->string('priority_type_bank');
            $table->string('verify_through_bank');
            $table->string('client_remarks_bank');
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
            $table->dropColumn('type_of_endorsement_bank');
            $table->dropColumn('loan_type_bank');
            $table->dropColumn('priority_type_bank');
            $table->dropColumn('verify_through_bank');
            $table->dropColumn('client_remarks_bank');
        });
    }
}
