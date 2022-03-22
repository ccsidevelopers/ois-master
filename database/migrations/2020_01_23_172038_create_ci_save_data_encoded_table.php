<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCiSaveDataEncodedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ci_save_data_encoded', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('endorsements_id');
            $table->integer('ci_id');
            $table->text('encoded');
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
        Schema::dropIfExists('ci_save_data_encoded');
    }
}
