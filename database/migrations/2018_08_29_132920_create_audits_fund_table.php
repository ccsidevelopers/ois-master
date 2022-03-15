<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditsFundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audits_fund', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fund_id');
            $table->string('name', 50);
            $table->string('position', 30);
            $table->string('branch', 40);
            $table->text('activities');
            $table->date('date_occured');
            $table->time('time_occured');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audits_fund');
    }
}
