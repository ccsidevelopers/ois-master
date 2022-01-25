<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableContractAudits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_audits', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('contract_id');
            $table->string('name');
            $table->string('position');
            $table->string('branch');
            $table->string('activities');
            $table->date('date_occured');
            $table->time('time_occured');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contract_audits');
    }
}
