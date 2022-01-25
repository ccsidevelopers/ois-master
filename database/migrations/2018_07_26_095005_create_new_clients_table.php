<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_name',100);
            $table->date('date_inquiry',50);
            $table->text('address');
            $table->string('contact_person');
            $table->string('contact_position');
            $table->string('contact_number');
            $table->string('contact_email');
            $table->text('require_check');
            $table->text('hash_bi');
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
        Schema::dropIfExists('new_clients');
    }
}
