<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCiEncodeFormInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ci_encode_form_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('temp_name',255);
            $table->string('temp_name_file',255);
            $table->string('sheet_name_template',255);
            $table->integer('temp_col_count');
            $table->string('sheet_name_validation',255);
            $table->integer('validation_col_start');
            $table->integer('validation_col_end');
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
        Schema::dropIfExists('ci_encode_form_info');
    }
}
