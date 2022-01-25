<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFundRequestCiEndorsements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_request_endorsements', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('fund_id');
            $table->integer('endorsement_id');
            $table->string('type',100);
            $table->string('type_label',100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fund_request_endorsements');
    }
}
