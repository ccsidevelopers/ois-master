<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersWorkExperienceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_work_experience', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('company_name');
            $table->string('company_address');
            $table->string('company_position');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('contact_no');
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
        Schema::dropIfExists('users_work_experience');
    }
}
