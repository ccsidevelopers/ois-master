<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCharacterReferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_character_reference', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('char_name');
            $table->string('char_position');
            $table->string('char_company_name');
            $table->string('char_contact');
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
        Schema::dropIfExists('user_character_reference');
    }
}
