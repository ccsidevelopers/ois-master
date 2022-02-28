<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoborrowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coborrowers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('endorsement_id');
            $table->string('coborrower_name',70);
            $table->string('coborrower_address',100);
            $table->string('coborrower_municipality',100);
            $table->string('coborrower_province',100);
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
        Schema::drop('coborrowers');
    }
}
