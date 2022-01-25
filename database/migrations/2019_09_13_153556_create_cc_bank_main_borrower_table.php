<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCcBankMainBorrowerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cc_bank_main_borrower', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bi_id');
            $table->string('loan_applied_unit');
            $table->string('loan_downpayment');
            $table->string('loan_term');
            $table->string('loan_first_personal');
            $table->string('existing_bank');
            $table->string('existing_type_loan');
            $table->string('existing_loan_term');
            $table->string('existing_monthly_payment');
            $table->string('l_name');
            $table->string('f_name');
            $table->string('m_name');
            $table->string('mother_maiden_name');
            $table->date('birth_date');
            $table->string('place_birth');
            $table->string('civil_status');
            $table->string('kyc_tin_sss');
            $table->text('present_complete');
            $table->string('present_length');
            $table->string('present_proof_billing');
            $table->string('present_house_ownership');
            $table->text('perma_complete');
            $table->string('perma_length');
            $table->string('perma_proof_billing');
            $table->string('perma_house_ownership');
            $table->string('bank_name');
            $table->string('bank_branch');
            $table->string('bank_type_account');
            $table->string('bank_account_no');
            $table->string('informant');
            $table->string('contacted_thru');
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
        Schema::dropIfExists('cc_bank_main_borrower');
    }
}
