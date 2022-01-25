<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiEndorsementsOtherInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bi_endorsements_other_informations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('endorsement_id');
            $table->string('sss');
            $table->string('philhealth');
            $table->string('pag_ibig');
            $table->string('tin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bi_endorsements_other_informations');
    }
}
