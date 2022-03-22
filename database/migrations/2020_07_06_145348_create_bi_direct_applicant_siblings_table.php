<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiDirectApplicantSiblingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bi_direct_applicant_siblings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('direct_id');
            $table->string('sibs_name');
            $table->string('sibs_age');
            $table->text('sibs_address');
            $table->string('sibs_occupation');
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
        Schema::dropIfExists('bi_direct_applicant_siblings');
    }
}
