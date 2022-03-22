<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiDirectApplicantChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bi_direct_applicant_children', function (Blueprint $table) {
            $table->increments('id');
            $table->string('direct_id');
            $table->string('children_name');
            $table->date('children_birthdate');
            $table->string('children_birthplace');
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
        Schema::dropIfExists('bi_direct_applicant_children');
    }
}
