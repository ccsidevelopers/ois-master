<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpPositionSuppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_position_supp', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('type_change');
            $table->string('position_transition');
            $table->string('position_old');
            $table->string('position_new');
            $table->string('supp_docu_path');
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
        Schema::dropIfExists('emp_position_supp');
    }
}
