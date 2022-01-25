<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhoneInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_atm', function (Blueprint $table) {
            $table->string('emp_phone_number');
            $table->integer('emp_phone_price');
            $table->text('emp_phone_desc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_atm', function (Blueprint $table) {
            $table->dropColumn('emp_phone_number');
            $table->dropColumn('emp_phone_price');
            $table->dropColumn('emp_phone_desc');
        });
    }
}
