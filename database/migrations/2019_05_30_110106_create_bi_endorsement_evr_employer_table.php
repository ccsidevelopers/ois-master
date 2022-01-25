<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiEndorsementEvrEmployerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bi_endorsement_evr_employer', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bi_id');
            $table->string('emp_name');
            $table->string('emp_address');
            $table->string('emp_muni');
            $table->string('emp_prov');
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
        Schema::dropIfExists('bi_endorsement_evr_employer');
    }
}
