<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiEndorsementsCheckingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bi_endorsements_checkings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bi_endorsement_id');
            $table->integer('checking_id');
            $table->text('checking_name');
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
        Schema::dropIfExists('bi_endorsements_checkings');
    }
}
