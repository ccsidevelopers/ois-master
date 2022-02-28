<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCcBankBorrowerRecentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cc_bank_borrower_recent', function (Blueprint $table) {
            $table->increments('id');
            $table->text('complete_address');
            $table->string('length_stay');
            $table->string('proof_billing');
            $table->string('house_ownership');
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
        Schema::dropIfExists('cc_bank_borrower_recent');
    }
}
