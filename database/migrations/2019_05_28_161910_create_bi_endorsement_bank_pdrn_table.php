<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiEndorsementBankPdrnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bi_endorsement_cob_pdrn', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bi_id');
            $table->string('f_name');
            $table->string('m_name');
            $table->string('l_name');
            $table->string('present_address');
            $table->string('present_muni');
            $table->string('present_prov');
            $table->string('perma_address');
            $table->string('perma_muni');
            $table->string('perma_prov');
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
        Schema::dropIfExists('bi_endorsement_bank_pdrn');
    }
}
