<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRequestListitem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_listitem', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('item_request_id');
            $table->string('item_name');
            $table->string('item_desc');
            $table->string('item_purp');
            $table->string('item_qty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
