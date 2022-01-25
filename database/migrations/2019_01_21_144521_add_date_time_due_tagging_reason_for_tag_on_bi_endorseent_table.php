<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateTimeDueTaggingReasonForTagOnBiEndorseentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bi_endorsements', function (Blueprint $table) {
            $table->string('account_upload_status',255)->after('status');
            $table->dateTime('data_time_due')->after('account_upload_status');
            $table->string('tagging',255)->after('attach_4');
            $table->text('reason_for_tagging')->after('tagging');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bi_endorsements', function ($table) {
            $table->dropColumn('account_upload_status');
            $table->dropColumn('data_time_due');
            $table->dropColumn('tagging');
            $table->dropColumn('reason_for_tagging');
        });
    }
}
