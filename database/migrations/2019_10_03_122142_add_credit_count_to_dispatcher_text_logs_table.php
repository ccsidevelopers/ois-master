<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreditCountToDispatcherTextLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dispatcher_text_logs', function (Blueprint $table) {
            $table->string('credit_count')->after('contact_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dispatcher_text_logs', function (Blueprint $table) {
            $table->dropColumn('credit_count');
        });
    }
}
