<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCobBarSeaKyc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cc_bank_coborrower', function (Blueprint $table) {
            $table->string('kyc_sss')->after('kyc_tin_sss');
            $table->text('barangay_remarks');
            $table->text('seaman_ofw_remarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cc_bank_coborrower', function (Blueprint $table) {
            $table->dropColumn('kyc_sss');
            $table->dropColumn('barangay_remarks');
            $table->dropColumn('seaman_ofw_remarks');
        });
    }
}
