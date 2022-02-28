<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiDirectEncodedDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bi_direct_encoded_data', function (Blueprint $table) {
            $table->increments('id');
            $table->string('accnt_fname');
            $table->string('accnt_surname');
            $table->string('accnt_mname');
            $table->string('accnt_suffix');
            $table->string('accnt_civil_status');
            $table->string('accnt_gender');
            $table->string('accnt_bday');
            $table->string('accnt_age');
            $table->string('accnt_present_add');
            $table->string('accnt_present_mun_id');
            $table->string('accnt_present_prov_id');
            $table->string('accnt_permanent_add');
            $table->string('accnt_permanent_mun_id');
            $table->string('accnt_permanent_prov_id');
            $table->string('attach1');
            $table->string('attach2');
            $table->string('attach3');
            $table->string('attach4');
            $table->string('status');
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
        Schema::dropIfExists('bi_direct_encoded_data');
    }
}
