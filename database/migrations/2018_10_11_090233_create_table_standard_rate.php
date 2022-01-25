<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStandardRate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standard_rate', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('municipalities');
            $table->string('provinces');
            $table->integer('rate');
            $table->integer('vat');
            $table->integer('tat');
            $table->integer('total_rate');
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
        Schema::dropIfExists('standard_rate');
    }
}
