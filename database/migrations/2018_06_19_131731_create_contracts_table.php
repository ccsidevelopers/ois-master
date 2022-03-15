<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('client_name');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('contract_desc');
            $table->string('contract_remarks');
            $table->text('hash_contracts');
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
        Schema::drop('contracts');
    }
}
