<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaypalTransactionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paypal_transaction_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_id');
            $table->string('payee_name');
            $table->string('payee_address');
            $table->string('payee_email');
            $table->text('payee_payment_desc');
            $table->string('payee_phonenumber');
            $table->integer('amount_paid');
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
        Schema::dropIfExists('paypal_transaction_logs');
    }
}
