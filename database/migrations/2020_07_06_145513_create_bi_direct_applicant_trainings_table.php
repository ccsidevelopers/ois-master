<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiDirectApplicantTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bi_direct_applicant_trainings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('direct_id');
            $table->string('train_title');
            $table->string('train_conducted');
            $table->string('train_year');
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
        Schema::dropIfExists('bi_direct_applicant_trainings');
    }
}
