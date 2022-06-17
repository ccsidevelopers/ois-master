<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKioskEndorsementLoanTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kiosk_endorsement_loan_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('kiosk_endorsement_id');
            $table->string('motorcycle_loan')->nullable();
            $table->string('personal_salary_loan')->nullable();
            $table->string('auto_loan')->nullable();
            $table->string('home_house_loan')->nullable();
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
        Schema::dropIfExists('kiosk_endorsement_loan_types');
    }
}
