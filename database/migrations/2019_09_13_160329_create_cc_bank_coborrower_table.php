<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCcBankCoborrowerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cc_bank_coborrower', function (Blueprint $table) {
            $table->increments('id');
            $table->string('l_name');
            $table->string('f_name');
            $table->string('m_name');
            $table->string('mother_maiden_name');
            $table->date('birth_date');
            $table->string('place_birth');
            $table->string('civil_status');
            $table->string('kyc_tin_sss');
            $table->string('relationship_to_borrower');
            $table->string('dependents');
            $table->string('type_comaker');
            $table->text('present_complete');
            $table->string('present_length');
            $table->string('present_proof_billing');
            $table->string('present_house_ownership');
            $table->text('perma_complete');
            $table->string('perma_length');
            $table->string('perma_proof_billing');
            $table->string('perma_house_ownership');
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
        Schema::dropIfExists('cc_bank_coborrower');
    }
}
