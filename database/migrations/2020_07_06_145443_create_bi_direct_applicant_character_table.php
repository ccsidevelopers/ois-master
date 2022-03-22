<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiDirectApplicantCharacterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bi_direct_applicant_character', function (Blueprint $table) {
            $table->increments('id');
            $table->string('direct_id');
            $table->string('charac_name');
            $table->text('charac_address');
            $table->string('charac_email');
            $table->string('charac_contact');
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
        Schema::dropIfExists('bi_direct_applicant_character');
    }
}
