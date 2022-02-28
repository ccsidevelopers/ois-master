<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCcBankBvrSoiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cc_bank_bvr_soi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bus_name');
            $table->string('length_operation');
            $table->string('industry_bus');
            $table->string('registration_bus');
            $table->string('number_employees');
            $table->string('monthly_income');
            $table->text('bus_address');
            $table->string('length_stay');
            $table->string('bus_ownership');
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
        Schema::dropIfExists('cc_bank_bvr_soi');
    }
}
