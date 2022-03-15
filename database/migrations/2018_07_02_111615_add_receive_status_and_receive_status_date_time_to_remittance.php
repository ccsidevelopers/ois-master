<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReceiveStatusAndReceiveStatusDateTimeToRemittance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('remittance', function (Blueprint $table) {
            $table->string('receive_status',50)->after('receive_receipt_date_time');
            $table->dateTime('receive_status_date_time')->after('receive_status');
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
            $table->dropColumn('receive_status');
            $table->dropColumn('receive_status_date_time');
        });
    }
}
