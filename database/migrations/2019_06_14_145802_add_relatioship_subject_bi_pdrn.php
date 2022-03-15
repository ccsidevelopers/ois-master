<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelatioshipSubjectBiPdrn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bi_endorsement_cob_pdrn', function (Blueprint $table) {
            $table->string('relationship_subject');
            $table->string('other_relationship_subject');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bi_endorsement_cob_pdrn', function (Blueprint $table) {
            $table->dropColumn('relationship_subject');
            $table->dropColumn('other_relationship_subject');
        });
    }
}
