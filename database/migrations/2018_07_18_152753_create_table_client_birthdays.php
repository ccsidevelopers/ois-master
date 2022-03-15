<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableClientBirthdays extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_birthdays', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('client_name');
            $table->date('birthdate');
            $table->string('contact_num');
            $table->string('email_add');
            $table->string('client_position');
            $table->string('gift_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('client_birthdays');
    }
}
