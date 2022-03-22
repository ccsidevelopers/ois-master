<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiDirectPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bi_direct_pivot', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bi_id');
            $table->string('direct_to_get_id');
            $table->string('direct_name');
            $table->string('direct_type');
            $table->string('direct_status');
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
        Schema::dropIfExists('bi_direct_pivot');
    }
}
