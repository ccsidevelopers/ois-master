<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdditionalFilesFromBiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_files_from_bi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('endorsement_id');
            $table->text('type_of_return');
            $table->integer('bi_id');
            $table->text('file_names');
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
        Schema::dropIfExists('additional_files_from_bi');
    }
}
