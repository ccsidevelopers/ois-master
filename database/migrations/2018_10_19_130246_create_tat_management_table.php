<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTatManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tat_management', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('muni_id');
            $table->integer('prov_id');
            $table->integer('client_id');
            $table->float('fw_tat');
            $table->float('obw_tat');
            $table->float('agreed_tat');
            $table->date('date');
            $table->time('time');
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
        Schema::dropIfExists('tat_management');
    }
}
