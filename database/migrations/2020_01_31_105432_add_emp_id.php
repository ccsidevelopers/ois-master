<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmpId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_requisition', function (Blueprint $table) {
            $table->string('requested_for');
            $table->string('requested_for_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_requisition', function (Blueprint $table) {
            $table->dropColumn('requested_for');
            $table->dropColumn('requested_for_id');
        });
    }
}
