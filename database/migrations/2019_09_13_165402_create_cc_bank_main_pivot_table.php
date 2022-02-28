<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCcBankMainPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cc_bank_main_pivot', function (Blueprint $table) {
            $table->increments('id');
            $table->string('main_id');
            $table->string('evr_id');
            $table->string('bvr_id');
            $table->string('cob_id');
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
        Schema::dropIfExists('cc_bank_main_pivot');
    }
}
