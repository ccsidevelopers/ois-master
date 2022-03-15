<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReceiveReceiptDateTimeToRemittanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('remittance', function (Blueprint $table) {
            $table->dateTime('receive_receipt_date_time')->after('attachment_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('remittance', function ($table) {
            $table->dropColumn('receive_receipt_date_time');
        });
    }
}
