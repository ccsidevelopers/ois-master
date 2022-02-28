<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnLogStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audits_log', function (Blueprint $table) {
            $table->integer('audit_status');
            $table->integer('escalation_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audits_log', function (Blueprint $table) {
            $table->dropColumn('audit_status');
            $table->dropColumn('escalation_status');
        });
    }
}
