<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSuppStatusPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_accredited_suppliers', function (Blueprint $table) {
           $table->string('approval_status');
           $table->string('pivot_request');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_accredited_suppliers', function (Blueprint $table) {
            $table->string('approval_status');
            $table->string('pivot_request');
        });
    }
}
