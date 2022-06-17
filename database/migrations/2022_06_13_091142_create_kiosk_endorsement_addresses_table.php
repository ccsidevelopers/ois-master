<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKioskEndorsementAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kiosk_endorsement_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('kiosk_endorsement_id');
            $table->string('unit_number_bld_st_subd_brgy');
            $table->string('city_municipality');
            $table->string('province');
            $table->string('address_type');
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
        Schema::dropIfExists('kiosk_endorsement_addresses');
    }
}
