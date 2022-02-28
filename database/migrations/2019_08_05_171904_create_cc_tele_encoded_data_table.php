<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCcTeleEncodedDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cc_tele_encoded_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('bi_endorsement_id');
            $table->integer('checking_id');
            $table->string('label');
            $table->text('inputted');
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
        Schema::dropIfExists('cc_tele_encoded_data');
    }
}
