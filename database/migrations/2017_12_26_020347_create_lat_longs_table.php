<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLatLongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lat_longs', function (Blueprint $table)
        {
            $table->increments('id');
            $table->Integer('CI_ID');
            $table->String('CI_Name');
            $table->String('Lat');
            $table->String('Long');
            $table->String('Status');
            $table->String('Last_Update');
            $table->String('Time_Limit');
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
        Schema::drop('lat_longs');
    }
}
