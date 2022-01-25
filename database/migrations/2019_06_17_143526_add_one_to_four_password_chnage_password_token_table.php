<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOneToFourPasswordChnagePasswordTokenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('change_password_token', function (Blueprint $table) {
            //
            $table->string('one_password',255)->after('pass');
            $table->string('two_password',255)->after('one_password');
            $table->string('three_password',255)->after('two_password');
            $table->string('four_password',255)->after('three_password');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('change_password_token', function (Blueprint $table) {
            //
            $table->dropColumn('one_password');
            $table->dropColumn('two_password');
            $table->dropColumn('three_password');
            $table->dropColumn('four_password');
        });
    }
}
