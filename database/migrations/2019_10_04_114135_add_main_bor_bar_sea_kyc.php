<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMainBorBarSeaKyc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cc_bank_main_borrower', function (Blueprint $table) {
            $table->string('log_save_file');
            $table->string('kyc_sss')->after('kyc_tin_sss');
            $table->text('barangay_remarks');
            $table->text('seaman_ofw_remarks');
            $table->text('general_remarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cc_bank_main_borrower', function (Blueprint $table) {
            $table->dropColumn('log_save_file');
            $table->dropColumn('kyc_sss');
            $table->dropColumn('barangay_remarks');
            $table->dropColumn('seaman_ofw_remarks');
            $table->dropColumn('general_remarks');
        });
    }
}
