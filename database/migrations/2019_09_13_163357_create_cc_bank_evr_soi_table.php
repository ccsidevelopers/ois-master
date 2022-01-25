<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCcBankEvrSoiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cc_bank_evr_soi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('employer_name');
            $table->string('emp_tenure');
            $table->string('position_rank');
            $table->string('monthly_salary');
            $table->text('employer_address');
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
        Schema::dropIfExists('cc_bank_evr_soi');
    }
}
