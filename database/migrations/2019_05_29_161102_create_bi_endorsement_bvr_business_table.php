<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiEndorsementBvrBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bi_endorsement_bvr_business', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bi_id');
            $table->string('business_name');
            $table->string('business_address');
            $table->string('business_muni');
            $table->string('business_prov');
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
        Schema::dropIfExists('bi_endorsement_bvr_business');
    }
}
