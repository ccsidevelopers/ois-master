<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_login');
            $table->string('branch_id');
            $table->string('emp_position');
            $table->date('emp_date_hired');
            $table->string('emp_age');
            $table->string('emp_first_name');
            $table->string('emp_middle_name');
            $table->string('emp_last_name');
            $table->string('emp_full_name');
            $table->string('emp_nickname');
            $table->string('emp_religion');
            $table->string('emp_gender');
            $table->date('emp_date_birth');
            $table->string('emp_marital_status');
            $table->string('emp_profile_pic');
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
        Schema::dropIfExists('users_profile');
    }
}
